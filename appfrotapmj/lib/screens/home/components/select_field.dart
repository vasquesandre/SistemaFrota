import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:shop_app/screens/sign_in/components/sign_form.dart';

import '../../../constants.dart';

class SelectItem {
  final String text;
  final String value;

  SelectItem({required this.text, required this.value});
}

class SelectField extends StatefulWidget {
  final List<SelectItem> items;
  const SelectField({
    Key? key,
    required this.onChanged,
    required this.items,
    this.hintText = 'Selecione seu Carro',
  }) : super(key: key);

  final ValueChanged<String?> onChanged;
  final String hintText;

  @override
  _SelectFieldState createState() => _SelectFieldState();
}

class _SelectFieldState extends State<SelectField> {
  String? _selectedItem;
  List<SelectItem> _items = [];

  @override
  void initState() {
    super.initState();
    _fetchItemsFromServer();
  }

  Future<void> _fetchItemsFromServer() async {
    try {
      int? idLogin = await getIdLogin();

      print(idLogin);

      if (idLogin != null) {
        final response = await http.post(
          Uri.parse(
              'http://ipconfig/sistemacarro/scriptsFlutter/buscar_meus_veiculos.php'),
          body: {
            'id_login': idLogin.toString(), // Adiciona o idLogin como parâmetro
          },
        );

        print(response.body);

        if (response.statusCode == 200) {
          final List<SelectItem> items = [];
          final List<dynamic> data = jsonDecode(response.body);
          data.forEach((item) {
            items.add(SelectItem(
              text: '${item['placa']} / ${item['modelo']}',
              value: item['id_veiculo'].toString(),
            ));
          });

          print(items);

          setState(() {
            _items = items;
          });
        } else {
          throw Exception('Failed to load items');
        }
      } else {
        throw Exception('IdLogin is null');
      }
      // Recuperar idLogin
    } catch (e) {
      print('Error fetching items: $e');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Form(
      child: DropdownButtonFormField<String>(
        value: _selectedItem,
        onChanged: (value) {
          setState(() {
            _selectedItem = value;
          });
          widget.onChanged(value);
        },
        items: _items.map((item) {
          return DropdownMenuItem<String>(
            value: item.value,
            child: Text(item.text),
          );
        }).toList(),
        decoration: InputDecoration(
          filled: true,
          fillColor: kSecondaryColor.withOpacity(0.1),
          contentPadding:
              const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
          border: searchOutlineInputBorder,
          focusedBorder: searchOutlineInputBorder,
          enabledBorder: searchOutlineInputBorder,
          hintText: widget.hintText,
        ),
      ),
    );
  }
}

const searchOutlineInputBorder = OutlineInputBorder(
  borderRadius: BorderRadius.all(Radius.circular(12)),
  borderSide: BorderSide.none,
);
