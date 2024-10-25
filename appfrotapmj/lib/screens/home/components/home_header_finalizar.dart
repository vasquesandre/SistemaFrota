import 'dart:async';
import 'dart:convert';
import 'dart:isolate';
import 'dart:ui';

import 'package:flutter/material.dart';
import 'package:flutter_background_service/flutter_background_service.dart';
import 'package:http/http.dart' as http;
import 'package:shop_app/helper/keyboard.dart';
import 'package:shop_app/screens/home/components/home_header.dart';
import 'package:shop_app/screens/home/components/km_field.dart';
import 'package:shop_app/screens/home/components/location_service.dart';
import 'package:shop_app/screens/home/home_screen.dart';
import 'package:shop_app/screens/init_screen.dart';
import 'package:shop_app/screens/sign_in/components/sign_form.dart';

import 'section_title.dart';

class HomeHeaderFinalizar extends StatefulWidget {
  const HomeHeaderFinalizar({Key? key}) : super(key: key);

  @override
  _HomeHeaderFinalizarState createState() => _HomeHeaderFinalizarState();
}

class _HomeHeaderFinalizarState extends State<HomeHeaderFinalizar> {

  final List<String> items = ['Item 1', 'Item 2', 'Item 3'];
  String? selectedCar;
  String? selectedKm;

  bool isLoading = false;

  @override
  void initState() {
    super.initState();
  }

  void handleKmChanged(String? value) {
    setState(() {
      selectedKm = value;
      print('Km digitado: $value');
    });
  }

  Future<bool> finalizarViagem(String? selectedKm) async {
    if (selectedKm == null) {
      return false;
    }

    await sendLocationsToDatabase();

    int? idLogin = await getIdLogin();
    int? idViagem = await getIdViagem();

    var url =
        'http://ipconfig/sistemacarro/scriptsFlutter/processa_finalizar_viagem.php';
    var response = await http.post(Uri.parse(url), body: {
      'id_login': idLogin.toString(),
      'id_viagem': idViagem.toString(),
      'kmFinal': selectedKm
    });

    if (response.statusCode == 200) {
      // Viagem finalizada com sucesso
      print('Viagem finalizada com sucesso!');

      Navigator.pushNamed(context, HomeScreen.routeName);

      pararBackgroundLocation();

      return true;
    } else {
      // Falha ao finalizar a viagem
      print(
          'Falha ao finalizar a viagem. Código de status: ${response.statusCode}');
      return false;
    }
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const SizedBox(height: 20),
        Padding(
          padding: const EdgeInsets.symmetric(horizontal: 20),
          child: SectionTitle(
            title: "Digite a quilometragem final do veículo",
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
          child: !isLoading
              ? ElevatedButton(
                  onPressed: () async {
                    setState(() {
                      isLoading = true;
                    });

                    KeyboardUtil.hideKeyboard(context);
                    bool success = await finalizarViagem(selectedKm);

                    setState(() {
                      isLoading = false;
                    });
                  },
                  child: Text('Finalizar Viagem'),
                )
              : Center(child: CircularProgressIndicator()),
        ),
      ],
    );
  }
}
