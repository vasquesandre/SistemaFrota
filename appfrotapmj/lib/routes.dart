import 'package:flutter/widgets.dart';
import 'package:shop_app/screens/profile/meus_carros_screen.dart';

import 'screens/cart/cart_screen.dart';
import 'screens/home/home_screen.dart';
import 'screens/home/finalizar_screen.dart';
import 'screens/init_screen.dart';
import 'screens/login_success/login_success_screen.dart';
import 'screens/profile/profile_screen.dart';
import 'screens/sign_in/sign_in_screen.dart';
import 'screens/splash/splash_screen.dart';

// We use name route
// All our routes will be available here
final Map<String, WidgetBuilder> routes = {
  InitScreen.routeName: (context) => const InitScreen(),
  SplashScreen.routeName: (context) => const SplashScreen(),
  SignInScreen.routeName: (context) => const SignInScreen(),
  LoginSuccessScreen.routeName: (context) => const LoginSuccessScreen(),
  HomeScreen.routeName: (context) => const HomeScreen(),
  FinalizarScreen.routeName: (context) => const FinalizarScreen(),
  CartScreen.routeName: (context) => const CartScreen(),
  ProfileScreen.routeName: (context) => const ProfileScreen(),
  MeusVeiculosScreen.routeName: (context) => const MeusVeiculosScreen(items: [],),
};