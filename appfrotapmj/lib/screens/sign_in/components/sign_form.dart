import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:http/http.dart' as http;
import 'package:shop_app/screens/home/components/home_header.dart';
import 'package:shop_app/screens/home/finalizar_screen.dart';
import 'package:shop_app/screens/init_screen.dart';
import 'package:permission_handler/permission_handler.dart';
import 'dart:convert';

import '../../../components/custom_surfix_icon.dart';
import '../../../components/form_error.dart';
import '../../../constants.dart';
import '../../../helper/keyboard.dart';

import 'package:shared_preferences/shared_preferences.dart';

Future<void> saveIdLogin(int idLogin) async {
  final SharedPreferences prefs = await SharedPreferences.getInstance();
  await prefs.setInt('id_login', idLogin);
}

Future<int?> getIdLogin() async {
  final SharedPreferences prefs = await SharedPreferences.getInstance();
  return prefs.getInt('id_login');
}

Future<void> saveNome(String nome) async {
  final SharedPreferences prefs = await SharedPreferences.getInstance();
  await prefs.setString('nome', nome);
}

Future<String?> get getNome async {
  final SharedPreferences prefs = await SharedPreferences.getInstance();
  return prefs.getString('nome');
}

Future<void> saveMatricula(int matricula) async {
  final SharedPreferences prefs = await SharedPreferences.getInstance();
  await prefs.setInt('matricula', matricula);
}

Future<int?> get getMatricula async {
  final SharedPreferences prefs = await SharedPreferences.getInstance();
  return prefs.getInt('matricula');
}

Future<bool> signIn(
    String username, String password, BuildContext context) async {
  print('Tentando fazer login...');

  var url =
      'http://ipconfig/sistemacarro/scriptsFlutter/conexaoAdFlutter.php';
  var response = await http.post(Uri.parse(url), body: {
    'username': username,
    'password': password,
  });

  print('Response body: ${response.body}, ${response.statusCode}');

  var responseData = jsonDecode(response.body);

  if (response.statusCode == 200) {
    if (responseData.containsKey('id_login')) {
      var idLogin = responseData['id_login'];
      await saveIdLogin(idLogin);
    }
    if (responseData.containsKey('nome')) {
      var nome = responseData['nome'];
      await saveNome(nome);
    }
    if (responseData.containsKey('matricula')) {
      var matricula = responseData['matricula'];
      await saveMatricula(matricula);
    }

    if (responseData.containsKey('id_viagem')) {
      var idViagem = responseData['id_viagem'];
      await saveIdViagem(idViagem);
      Navigator.pushNamed(context, FinalizarScreen.routeName);
    } else {
      Navigator.pushNamed(context, InitScreen.routeName);
    }

    return true;
  } else {
    print('Falha no login. Código de status: ${response.statusCode}');
    return false;
  }
}

class LowerCaseTextFormatter extends TextInputFormatter {
  @override
  TextEditingValue formatEditUpdate(
      TextEditingValue oldValue, TextEditingValue newValue) {
    return TextEditingValue(
      text: newValue.text.toLowerCase(),
      selection: newValue.selection,
    );
  }
}

class SignForm extends StatefulWidget {
  const SignForm({Key? key}) : super(key: key);

  @override
  _SignFormState createState() => _SignFormState();
}

class _SignFormState extends State<SignForm> with WidgetsBindingObserver {
  final _formKey = GlobalKey<FormState>();
  String? username;
  String? password;
  bool? remember = false;
  bool _formValid = false;

  bool isLoading = false;

  final List<String?> errors = [];

  void initState() {
    super.initState();
    checkLocationPermission();
    WidgetsBinding.instance.addObserver(this);
  }

  void didChangeAppLifecycleState(AppLifecycleState state) {
    super.didChangeAppLifecycleState(state);
    if (state == AppLifecycleState.resumed) {
      checkLocationPermission();
    }
  }

  Future<void> checkLocationPermission() async {
    PermissionStatus status = await Permission.locationAlways.status;

    setState(() {
      if (status == PermissionStatus.granted) {
        _formValid = true;
      } else {
        _formValid = false;
      }
    });

    print('\n\nTrackingRepository.requestLocationPermission()\n'
        'Permission.location TESTE VERIFY .status is: $status');
  }

  void addError({String? error}) {
    if (!errors.contains(error)) {
      setState(() {
        errors.add(error);
      });
    }
  }

  void removeError({String? error}) {
    if (errors.contains(error)) {
      setState(() {
        errors.remove(error);
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Form(
      key: _formKey,
      child: Column(
        children: [
          TextFormField(
            keyboardType: TextInputType.text,
            inputFormatters: [
              LowerCaseTextFormatter(),
              FilteringTextInputFormatter.deny(RegExp(r"\s")),
            ],
            onSaved: (newValue) => username = newValue,
            onChanged: (value) {
              if (value.isNotEmpty) {
                removeError(error: kUserNullError);
              } else if (!usernameRegExp.hasMatch(value)) {
                removeError(error: kInvalidUserError);
              }
              return;
            },
            validator: (value) {
              if (value!.isEmpty) {
                addError(error: kUserNullError);
                return "";
              } else if (!usernameRegExp.hasMatch(value)) {
                addError(error: kInvalidUserError);
                return "";
              }
              return null;
            },
            decoration: const InputDecoration(
              labelText: "User",
              hintText: "Insira seu usuário",
              floatingLabelBehavior: FloatingLabelBehavior.always,
              suffixIcon: CustomSurffixIcon(svgIcon: "assets/icons/User.svg"),
            ),
          ),
          const SizedBox(height: 20),
          TextFormField(
            obscureText: true,
            onSaved: (newValue) => password = newValue,
            onChanged: (value) {
              if (value.isNotEmpty) {
                removeError(error: kPassNullError);
              } else if (value.length >= 8) {
                removeError(error: kShortPassError);
              }
              return;
            },
            validator: (value) {
              if (value!.isEmpty) {
                addError(error: kPassNullError);
                return "";
              } else if (value.length < 8) {
                addError(error: kShortPassError);
                return "";
              }
              return null;
            },
            decoration: const InputDecoration(
              labelText: "Senha",
              hintText: "Insira sua senha",
              floatingLabelBehavior: FloatingLabelBehavior.always,
              suffixIcon: CustomSurffixIcon(svgIcon: "assets/icons/Lock.svg"),
            ),
          ),
          const SizedBox(height: 20),
          FormError(errors: errors),
          const SizedBox(height: 16),
          !isLoading ? ElevatedButton(
            onPressed: _formValid
                ? () async {
                    if (_formKey.currentState!.validate()) {
                      _formKey.currentState!.save();

                      setState(() {
                        isLoading = true;
                      });

                      KeyboardUtil.hideKeyboard(context);
                      bool signInSuccess =
                          await signIn(username!, password!, context);
                      if (!signInSuccess) {
                        removeError(error: kUserNullError);
                        removeError(error: kInvalidUserError);
                        removeError(error: kPassNullError);
                        removeError(error: kShortPassError);
                        addError(error: kInvalidLogin);
                      }

                      setState(() {
                        isLoading = false;
                      });
                    }
                  }
                : null,
            child: Text(_formValid ? 'Entrar' : 'Necessário permitir localização sempre'),
          )
          : Center(child: CircularProgressIndicator())
        ],
      ),
    );
  }
}
