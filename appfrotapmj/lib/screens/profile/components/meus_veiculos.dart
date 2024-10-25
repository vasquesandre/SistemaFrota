import 'package:flutter/material.dart';
import 'package:shop_app/screens/home/components/select_field.dart';

import '../../../constants.dart';

class MeusVeiculos extends StatelessWidget {
  const MeusVeiculos({
    Key? key,
    required this.text,
    this.press,
    this.veiculos, // Adicione essa linha para aceitar a lista de veículos
  }) : super(key: key);

  final String text;
  final VoidCallback? press;
  final List<SelectItem>? veiculos; // Modifique essa linha para aceitar a lista de veículos

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 10),
      child: TextButton(
        style: TextButton.styleFrom(
          foregroundColor: kPrimaryColor, padding: const EdgeInsets.all(20),
          shape:
              RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
          backgroundColor: const Color(0xFFF5F6F9),
        ),
        onPressed: press,
        child: Row(
          children: [
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    text,
                    style: TextStyle(fontWeight: FontWeight.bold),
                  ),
                  if (veiculos != null)
                    for (var veiculo in veiculos!)
                      Text(
                        veiculo.text,
                        style: TextStyle(color: Colors.grey),
                      ),
                ],
              ),
            ),
            const Icon(Icons.arrow_forward_ios),
          ],
        ),
      ),
    );
  }
}
