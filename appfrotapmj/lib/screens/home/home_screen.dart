import 'package:flutter/material.dart';

import 'components/home_header.dart';

class HomeScreen extends StatelessWidget {
  static String routeName = "/home";

  const HomeScreen({super.key});
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: SingleChildScrollView(
          padding: EdgeInsets.symmetric(vertical: 16),
          child: Column(
            children: [
              Text(
                "Frota",
                style: Theme.of(context).textTheme.titleLarge,
              ),
              const SizedBox(height: 10),
              Text(
                "Iniciar Viagem",
                style: Theme.of(context).textTheme.titleMedium,
              ),
              HomeHeader(),
            ],
          ),
        ),
      ),
    );
  }
}