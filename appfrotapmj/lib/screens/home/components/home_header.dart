import 'dart:convert';
import 'dart:async';

import 'package:flutter/material.dart';
import 'package:geolocator/geolocator.dart';
import 'package:http/http.dart' as http;
import 'package:shop_app/helper/keyboard.dart';
import 'package:shop_app/screens/home/components/km_field.dart';
import 'package:shop_app/screens/home/finalizar_screen.dart';
import 'package:shop_app/screens/sign_in/components/sign_form.dart';
import 'package:shop_app/screens/home/components/location_service.dart';

import 'select_field.dart';
import 'section_title.dart';
import 'destination_field.dart';

import 'package:shared_preferences/shared_preferences.dart';

Future<void> saveIdViagem(int idViagem) async {
  final SharedPreferences prefs = await SharedPreferences.getInstance();
  await prefs.setInt('id_viagem', idViagem);
}

Future<int?> getIdViagem() async {
  final SharedPreferences prefs = await SharedPreferences.getInstance();
  return prefs.getInt('id_viagem');
}

class HomeHeader extends StatefulWidget {
  const HomeHeader({
    Key? key,
  }) : super(key: key);

  @override
  _HomeHeaderState createState() => _HomeHeaderState();
}

class _HomeHeaderState extends State<HomeHeader> with WidgetsBindingObserver {
  final List<SelectItem> items = [];
  String? selectedCar;
  String? selectedKm;
  String? selectedDestination;
  bool nullFields = false;

  bool isLoading = false;

  void handleKmChanged(String? value) {
    setState(() {
      selectedKm = value;
      print('Km digitado: $value');
      checkFields();
    });
  }

  void handleDestinationChanged(String? value) {
    setState(() {
      selectedDestination = value;
      print('Destino digitado: $value');
      checkFields();
    });
  }

  void checkFields() {
    setState(() {
      nullFields = selectedCar != null &&
          selectedKm != null &&
          selectedDestination != null;
    });
  }

  Future<bool> iniciarViagem(String? selectedCar, String? selectedKm,
      String? selectedDestination) async {
    if (selectedCar == null ||
        selectedKm == null ||
        selectedDestination == null) {
      return false;
    }

    int? idLogin = await getIdLogin();
    print(
        'Iniciando viagem com carro: $selectedCar, km: $selectedKm, destino: $selectedDestination, id: $idLogin');

    Position position = await Geolocator.getCurrentPosition(
        desiredAccuracy: LocationAccuracy.high);

    var url =
        'http://ipconfig/sistemacarro/scriptsFlutter/processa_iniciar_viagem.php';
    var response = await http.post(Uri.parse(url), body: {
      'id_login': idLogin.toString(),
      'veiculo': selectedCar,
      'km': selectedKm,
      'destino': selectedDestination,
      'latlong': '${position.latitude}, ${position.longitude}'
    });

    print(response.body);

    if (response.statusCode == 200) {
      print('Viagem iniciada com sucesso!');
      var responseData = jsonDecode(response.body);
      if (responseData.containsKey('id_viagem')) {
        var idViagem = responseData['id_viagem'];
        await saveIdViagem(idViagem);
        print("id viagem: $idViagem");

        // Inicialize o serviço de localização em background
        await iniciarBackgroundLocation();

        Navigator.pushNamed(context, FinalizarScreen.routeName);
      }
      return true;
    } else {
      print(
          'Falha ao iniciar a viagem. Código de status: ${response.statusCode}');

      return false;
    }
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const SizedBox(height: 25),
        Padding(
          padding: const EdgeInsets.symmetric(horizontal: 20),
          child: SectionTitle(
            title: "Selecione seu Carro",
            press: () {},
          ),
        ),
        const SizedBox(height: 8),
        Padding(
          padding: const EdgeInsets.symmetric(horizontal: 20),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Expanded(
                child: SelectField(
                  items: items,
                  onChanged: (selectedItem) {
                    setState(() {
                      selectedCar = selectedItem;
                      print('Selecionado: $selectedItem');
                      checkFields();
                    });
                  },
                ),
              ),
            ],
          ),
        ),
        const SizedBox(height: 20),
        Padding(
          padding: const EdgeInsets.symmetric(horizontal: 20),
          child: SectionTitle(
            title: "Digite a quilometragem do veículo",
            press: () {},
          ),
        ),
        const SizedBox(height: 8),
        Padding(
          padding: const EdgeInsets.symmetric(horizontal: 20),
          child: KmField(
            onChanged: handleKmChanged,
          ),
        ),
        const SizedBox(height: 20),
        Padding(
          padding: const EdgeInsets.symmetric(horizontal: 20),
          child: SectionTitle(
            title: "Digite o destino",
            press: () {},
          ),
        ),
        const SizedBox(height: 8),
        Padding(
          padding: const EdgeInsets.symmetric(horizontal: 20),
          child: TextInputField(
            onChanged: handleDestinationChanged,
          ),
        ),
        const SizedBox(height: 20),
        Padding(
            padding: const EdgeInsets.symmetric(horizontal: 20),
            child: !isLoading
                ? ElevatedButton(
                    onPressed: () async {
                      setState(() {
                        isLoading = true;
                      });

                      KeyboardUtil.hideKeyboard(context);
                      await iniciarViagem(
                          selectedCar, selectedKm, selectedDestination);

                      setState(() {
                        isLoading = false;
                      });
                    },
                    child: Text('Iniciar Viagem'),
                  )
                : Center(child: CircularProgressIndicator())),
      ],
    );
  }
}
