import 'package:flutter/material.dart';

import 'components/home_header_finalizar.dart';

class FinalizarScreen extends StatelessWidget {
  static String routeName = "/finalizar";

  const FinalizarScreen({super.key});
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
                "Finalizar Viagem",
                style: Theme.of(context).textTheme.titleMedium,
              ),
              HomeHeaderFinalizar(),
            ],
          ),
        ),
      ),
    );
  }
}