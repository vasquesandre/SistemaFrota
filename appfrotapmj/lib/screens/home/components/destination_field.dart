import 'package:flutter/material.dart';
import 'package:flutter/services.dart'; // Importe a biblioteca de serviços do Flutter

import '../../../constants.dart';

class TextInputField extends StatefulWidget {
  const TextInputField({
    Key? key,
    required this.onChanged,
    this.hintText = 'Digite algo',
  }) : super(key: key);

  final ValueChanged<String?> onChanged;
  final String hintText;

  @override
  _TextInputFieldState createState() => _TextInputFieldState();
}

class _TextInputFieldState extends State<TextInputField> {
  final _controller = TextEditingController(); // Controlador para o campo de texto

  @override
  void dispose() {
    _controller.dispose(); // Limpar o controlador quando o widget for descartado
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return TextFormField(
      controller: _controller, // Definir o controlador para o campo de texto
      onChanged: widget.onChanged,
      keyboardType: TextInputType.text, // Definir o tipo de teclado para texto
      decoration: InputDecoration(
        filled: true,
        fillColor: kSecondaryColor.withOpacity(0.1),
        contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
        border: numberOutlineInputBorder,
        focusedBorder: numberOutlineInputBorder,
        enabledBorder: numberOutlineInputBorder,
        hintText: widget.hintText,
      ),
    );
  }
}

const numberOutlineInputBorder = OutlineInputBorder(
  borderRadius: BorderRadius.all(Radius.circular(12)),
  borderSide: BorderSide.none,
);
