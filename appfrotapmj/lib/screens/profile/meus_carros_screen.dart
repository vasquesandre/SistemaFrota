import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:shop_app/screens/profile/components/meus_veiculos.dart';
import 'package:shop_app/screens/sign_in/components/sign_form.dart';
import 'package:url_launcher/url_launcher.dart';

class MeusVeiculosScreen extends StatefulWidget {
  static String routeName = "/meusveiculos";

  final List<String> items;

  const MeusVeiculosScreen({Key? key, required this.items}) : super(key: key);

  @override
  _MeusVeiculosScreenState createState() => _MeusVeiculosScreenState();
}

class _MeusVeiculosScreenState extends State<MeusVeiculosScreen> {
  List<String> _items = []; // Alteração: Usar uma lista de Strings

  Future<void> _fetchItemsFromServer() async {
    try {
      int? idLogin = await getIdLogin();

      print(idLogin);

      if (idLogin != null) {
        final response = await http.post(
          Uri.parse(
              'http://ipconfig/sistemacarro/scriptsFlutter/buscar_meus_veiculos.php'),
          body: {
            'id_login': idLogin.toString(),
          },
        );

        print(response.body);

        if (response.statusCode == 200) {
          final List<String> items = [];
          final List<dynamic> data = jsonDecode(response.body);
          if (data.length > 0) {
            data.forEach((item) {
              items.add('${item['placa']} / ${item['modelo']}');
            });
          } else {
            items.add('Nenhum veículo vinculado, peça ao seu supervisor para vincular um carro ao seu perfil.');
          }

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
  void initState() {
    super.initState();
    _fetchItemsFromServer();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: SingleChildScrollView(
          padding: EdgeInsets.symmetric(vertical: 16),
          child: Column(
            children: [
              Text(
                "FrotaPMJ",
                style: Theme.of(context).textTheme.titleLarge,
              ),
              const SizedBox(height: 10),
              Text(
                "Meus Veículos",
                style: Theme.of(context).textTheme.titleMedium,
              ),
              // Renderiza um MeusVeiculos para cada veículo
              for (var item in _items)
                MeusVeiculos(
                  text: item,
                  press: _showExplanationDialog,
                ),
            ],
          ),
        ),
      ),
    );
  }

  final Uri _url = Uri.parse('http://192.168.254.24/sistemacarro');

  Future<void> _openURL() async {
    print('call');
    if (!await launchUrl(_url, mode: LaunchMode.externalApplication)) {
      throw Exception('Could not launch $_url');
    }
  }

  Future<void> _showExplanationDialog() async {
    return showDialog<void>(
      context: context,
      barrierDismissible: false,
      builder: (BuildContext context) {
        return AlertDialog(
          title: Text('Alteração Apenas no Site'),
          content: const SingleChildScrollView(
            child: ListBody(
              children: <Widget>[
                Text(
                    'Para alterar seus veículos, é necessário fazer login no site do FrotaPMJ, clique no ícone do usuário e depois em "Conta".\nClique em OK para abrir o site do FrotaPMJ.'),
              ],
            ),
          ),
          actions: <Widget>[
            TextButton(
              child: Text('OK'),
              onPressed: () async {
                Navigator.of(context).pop();
                await _openURL(); // Abre as configurações do aplicativo
              },
            ),
          ],
        );
      },
    );
  }
}
