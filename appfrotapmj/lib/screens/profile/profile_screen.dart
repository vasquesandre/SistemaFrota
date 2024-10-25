import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:shop_app/constants.dart';
import 'package:shop_app/screens/profile/meus_carros_screen.dart';
import 'package:shop_app/screens/sign_in/components/sign_form.dart';
import 'package:shop_app/screens/sign_in/sign_in_screen.dart';

import 'components/profile_menu.dart';

class ProfileScreen extends StatelessWidget {
  static String routeName = "/profile";

  const ProfileScreen({Key? key});

  Future<String?> _getNome() async {
    String? nome = await getNome;
    return nome;
  }

  Future<int?> _getMatricula() async {
    int? matricula = await getMatricula;
    return matricula;
  }

  @override
  Widget build(BuildContext context) {
    return FutureBuilder<String?>(
      future: _getNome(),
      builder: (context, nomeSnapshot) {
        return FutureBuilder<int?>(
          future: _getMatricula(),
          builder: (context, matriculaSnapshot) {
            if (nomeSnapshot.connectionState == ConnectionState.waiting ||
                matriculaSnapshot.connectionState == ConnectionState.waiting) {
              // Retorna um indicador de carregamento enquanto aguarda a conclusão da função
              return Center(
                child: CircularProgressIndicator(),
              );
            } else if (nomeSnapshot.hasError || matriculaSnapshot.hasError) {
              // Retorna um widget de erro caso ocorra um erro
              return Center(
                child: Text('Erro ao obter os dados do perfil'),
              );
            } else {
              // Se a função for concluída com sucesso, construa o widget com os dados obtidos
              final nome = nomeSnapshot.data;
              final matricula = matriculaSnapshot.data;

              return Scaffold(
                body: SafeArea(
                  child: SingleChildScrollView(
                    padding: EdgeInsets.symmetric(vertical: 16),
                    child: Column(
                      children: [
                        const Text(
                          "FrotaPMJ",
                          style: TextStyle(
                            fontSize: 32,
                            color: kPrimaryColor,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                        const SizedBox(height: 10),
                        Text(
                          "Configurações do Perfil",
                          style: Theme.of(context).textTheme.titleLarge,
                        ),
                        const SizedBox(height: 10),
                        Text(
                          nome ?? "Nome não encontrado",
                          style: Theme.of(context).textTheme.titleMedium,
                        ),
                        const SizedBox(height: 10),
                        Text(
                          matricula != null ? matricula.toString() : "Matrícula não encontrada",
                          style: Theme.of(context).textTheme.titleSmall,
                        ),
                        const SizedBox(height: 10),
                        const SizedBox(height: 20),
                        ProfileMenu(
                          text: "Meus Carros",
                          icon: "assets/icons/User Icon.svg",
                          press: () {
                            Navigator.pushNamed(
                                context, MeusVeiculosScreen.routeName);
                          },
                        ),
                        ProfileMenu(
                          text: "Sair",
                          icon: "assets/icons/Log out.svg",
                          press: () async {
                            await clearAuthenticationData();

                            Navigator.pushNamed(context, SignInScreen.routeName);
                          },
                        ),
                      ],
                    ),
                  ),
                ),
              );
            }
          },
        );
      },
    );
  }

  Future<void> clearAuthenticationData() async {
    final SharedPreferences prefs = await SharedPreferences.getInstance();
    prefs.remove("id_login");
    prefs.remove("matricula");
    prefs.remove("nome");
  }
}
