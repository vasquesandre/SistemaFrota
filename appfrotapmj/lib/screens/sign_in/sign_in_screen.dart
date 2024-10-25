import 'package:flutter/material.dart';
import 'package:permission_handler/permission_handler.dart';

import 'components/sign_form.dart';

class SignInScreen extends StatefulWidget {
  static String routeName = "/sign_in";

  const SignInScreen({Key? key}) : super(key: key);

  @override
  _SignInScreenState createState() => _SignInScreenState();
}

class _SignInScreenState extends State<SignInScreen>
    with WidgetsBindingObserver {

  @override
  void initState() {
    super.initState();
    requestLocationPermission();
    WidgetsBinding.instance.addObserver(this);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: Center(
          child: SizedBox(
            width: double.infinity,
            child: Padding(
              padding: EdgeInsets.symmetric(horizontal: 20),
              child: SingleChildScrollView(
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    SizedBox(height: 16),
                    Text(
                      "Frota PMJ",
                      style: TextStyle(
                        color: Colors.black,
                        fontSize: 24,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    SizedBox(height: 16),
                    Text(
                      "Diretoria de Tecnologia da Informação",
                      style: Theme.of(context).textTheme.titleMedium,
                    ),
                    Text(
                      "Prefeitura de Jacareí",
                      style: Theme.of(context).textTheme.titleMedium,
                    ),
                    SizedBox(height: 20),
                    SignForm(),
                  ],
                ),
              ),
            ),
          ),
        ),
      ),
    );
  }

  void didChangeAppLifecycleState(AppLifecycleState state) {
    super.didChangeAppLifecycleState(state);
    if (state == AppLifecycleState.resumed) {}
  }

  Future<String> requestLocationPermission() async {
    late String permission;
    var locationWhenInUseStatus =
        await Permission.locationWhenInUse.status.then((value) {
      print('\n\nTrackingRepository.requestLocationPermission()\n'
          'Permission.locationWhenInUse.status is: ${value.name}');
      return value;
    });

    /// locationWhenInUseStatus NOT Granted
    if (!locationWhenInUseStatus.isGranted) {
      print('\n\nTrackingRepository.requestLocationPermission()\n'
          'locationWhenInUseRequest NOT Granted, we now request it');

      /// Ask locationWhileInUse permission
      var locationWhenInUseRequest =
          await Permission.locationWhenInUse.request();
      print('\n\nTrackingRepository.requestLocationPermission()\n'
          'Permission.locationWhenInUse.request() status is: $locationWhenInUseRequest');

      /// locationWhenInUseRequest granted
      if (locationWhenInUseRequest.isGranted) {
        /// When in use NOW Granted
        print('\n\nTrackingRepository.requestLocationPermission()\n'
            'When in use NOW Granted');
        permission = 'whileInUse';
        PermissionStatus status = await Permission.locationAlways.request();

        if (status.isGranted) {
          /// Always is NOW Granted
          print('\n\nTrackingRepository.requestLocationPermission()\n'
              'Always use NOW Granted');
          permission = 'granted';
          print(
              '\n\nTrackingRepository.requestLocationPermission() locationAlways is Now Granted\n'
              'Permission.locationAlways.request() status is: $status');
        } else {
          //Do another stuff
        }
      }

      /// locationWhenInUseRequest not granted
      else {
        //The user deny the permission
        permission = 'denied';

        print('\n\nTrackingRepository.requestLocationPermission()\n'
            'Permission.locationWhenInUse.request is isPermanentlyDenied');
        permission = 'deniedForever';
        _showPermissionDialog();
        print(
            '\n\nTrackingRepository.requestLocationPermission() isPermanentlyDenied');
      }
    }

    /// locationWhenInUseStatus is ALREADY Granted
    else {
      print('\n\nTrackingRepository.requestLocationPermission()\n'
          'locationWhenInUse ALREADY Granted, we now check for locationAlways permission');
      permission = 'whenInUse';

      var locationAlwaysStatus =
          await Permission.locationAlways.status.then((value) {
        print(
            '\n\nTrackingRepository.requestLocationPermission()\nlocationWhenInUse already granted\n'
            'Permission.locationAlways.status is: ${value.name}');
        return value;
      });

      /// locationAlways is NOT Already Granted
      if (!locationAlwaysStatus.isGranted) {
        print('\n\nTrackingRepository.requestLocationPermission()\n'
            'locationAlways not granted, we now ask for permission');

        /// ask locationAlways permission
        var locationAlwaysRequest = await Permission.locationAlways.request();

        /// finally it opens the system popup
        print('\n\nTrackingRepository.requestLocationPermission()\n'
            'Permission.locationAlways.request() status is: $locationAlwaysRequest');

        /// locationAlways is NOW Granted
        if (locationAlwaysRequest.isGranted) {
          print('\n\nTrackingRepository.requestLocationPermission()\n'
              'locationAlways was Granted upon request');
          permission = 'granted';
        }

        /// locationAlways was NOT Granted
        else {
          print('\n\nTrackingRepository.requestLocationPermission()\n'
              'Permission.locationAlways.request() status was NOT Granted upon request, we now open AppSettings');
          _showPermissionDialog();
          // TODO: re-check locationAlways permission status??
        }
      }

      /// locationAlways is ALREADY Granted
      else {
        permission = 'granted';
      }
    }
    return permission;
  }

  Future<void> _showPermissionDialog() async {
    return showDialog<void>(
      context: context,
      barrierDismissible: false,
      builder: (BuildContext context) {
        return AlertDialog(
          title: Text('Localização Necessária'),
          content: const SingleChildScrollView(
            child: ListBody(
              children: <Widget>[
                Text(
                    'Para usar o aplicativo, é necessário conceder permissão de localização sempre.\n Clique em OK e assim que aparecer o pop-up clique em "Apenas Durante o Uso" e então clique em "Permitir Sempre". \n Sem esta permissão não é possível entrar no app.'),
              ],
            ),
          ),
          actions: <Widget>[
            TextButton(
              child: Text('OK'),
              onPressed: () async {
                Navigator.of(context).pop();
                await openAppSettings();// Abre as configurações do aplicativo
              },
            ),
          ],
        );
      },
    ).then((_) async {
      await Future.delayed(Duration(seconds: 1));
      await requestLocationPermission();
    });
  }

  @override
  void dispose() {
    WidgetsBinding.instance.removeObserver(this);
    super.dispose();
  }
}
