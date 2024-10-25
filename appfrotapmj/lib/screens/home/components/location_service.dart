import 'dart:async';
import 'dart:convert';
import 'dart:io';
import 'dart:ui';

import 'package:flutter/material.dart';
import 'package:flutter_background_service/flutter_background_service.dart';
import 'package:geolocator/geolocator.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'package:shop_app/screens/home/components/home_header.dart';
import 'package:shop_app/screens/sign_in/components/sign_form.dart';

import 'package:flutter_local_notifications/flutter_local_notifications.dart';
import 'package:shop_app/main.dart';
import 'package:device_info_plus/device_info_plus.dart';

List<Map<String, dynamic>> locationList = [];

Future<void> initializeService() async {
  print("INITIALIZE SERVICE");
  final service = FlutterBackgroundService();

  const AndroidNotificationChannel channel = AndroidNotificationChannel(
    'my_foreground',
    'MY FOREGROUND SERVICE',
    importance: Importance.low,
  );

  final FlutterLocalNotificationsPlugin flutterLocalNotificationsPlugin =
      FlutterLocalNotificationsPlugin();

  if (Platform.isIOS || Platform.isAndroid) {
    await flutterLocalNotificationsPlugin.initialize(
      const InitializationSettings(
        iOS: DarwinInitializationSettings(),
        android: AndroidInitializationSettings('ic_bg_service_small'),
      ),
    );
  }

  await flutterLocalNotificationsPlugin
      .resolvePlatformSpecificImplementation<
          AndroidFlutterLocalNotificationsPlugin>()
      ?.createNotificationChannel(channel);

  await service.configure(
    androidConfiguration: AndroidConfiguration(
      onStart: onStart,
      autoStart: true,
      isForegroundMode: true,
      notificationChannelId: 'my_foreground',
      initialNotificationTitle: 'AWESOME SERVICE',
      initialNotificationContent: 'Initializing',
      foregroundServiceNotificationId: 888,
    ),
    iosConfiguration: IosConfiguration(
      autoStart: true,
      onForeground: onStart,
      onBackground: onIosBackground,
    ),
  );
}

@pragma('vm:entry-point')
Future<bool> onIosBackground(ServiceInstance service) async {
  WidgetsFlutterBinding.ensureInitialized();
  DartPluginRegistrant.ensureInitialized();

  SharedPreferences preferences = await SharedPreferences.getInstance();
  await preferences.reload();
  final log = preferences.getStringList('log') ?? <String>[];
  log.add(DateTime.now().toIso8601String());
  await preferences.setStringList('log', log);

  return true;
}

@pragma('vm:entry-point')
void onStart(ServiceInstance service) async {
  print("ONSTART INITIALIZED");
  DartPluginRegistrant.ensureInitialized();

  final FlutterLocalNotificationsPlugin flutterLocalNotificationsPlugin =
      FlutterLocalNotificationsPlugin();

  if (service is AndroidServiceInstance) {
    service.on('setAsForeground').listen((event) {
      service.setAsForegroundService();
      print("invoke setforeground");
    });

    service.on('setAsBackground').listen((event) {
      service.setAsBackgroundService();
    });
  }

  service.on('stopService').listen((event) {
    service.stopSelf();
  });

  Timer.periodic(const Duration(seconds: 5), (timer) async {
    if (service is AndroidServiceInstance) {
      if (await service.isForegroundService()) {
        Position position = await Geolocator.getCurrentPosition(
            desiredAccuracy: LocationAccuracy.high);
        Map<String, dynamic> locationData = {
          'latitude': position.latitude,
          'longitude': position.longitude
        };
        locationList.add(locationData);

        if (locationList.length >= 10) {
          print(locationList);
          await sendLocationsToDatabase();
          locationList.clear();
        }

        /// OPTIONAL for use custom notification
        /// the notification id must be equals with AndroidConfiguration when you call configure() method.
        flutterLocalNotificationsPlugin.show(
          888,
          'COOL SERVICE',
          'Awesome ${DateTime.now()}',
          const NotificationDetails(
            android: AndroidNotificationDetails(
              'my_foreground',
              'MY FOREGROUND SERVICE',
              icon: 'ic_bg_service_small',
              ongoing: true,
            ),
          ),
        );

        // if you don't using custom notification, uncomment this
        service.setForegroundNotificationInfo(
          title: "My App Service",
          content: "Updated at ${DateTime.now()}",
        );
      }
    }

    /// you can see this log in logcat
    print('FLUTTER BACKGROUND SERVICE: ${DateTime.now()}');

    // test using external plugin
    final deviceInfo = DeviceInfoPlugin();
    String? device;
    if (Platform.isAndroid) {
      final androidInfo = await deviceInfo.androidInfo;
      device = androidInfo.model;
    } else if (Platform.isIOS) {
      final iosInfo = await deviceInfo.iosInfo;
      device = iosInfo.model;
    }

    service.invoke(
      'update',
      {
        "current_date": DateTime.now().toIso8601String(),
        "device": device,
      },
    );
  });
}

Future<void> sendLocationsToDatabase() async {
  int? idViagem = await getIdViagem();
  int? idLogin = await getIdLogin();

  var url =
      'http://ipconfig/sistemacarro/scriptsFlutter/atualizar_localizacao.php';
  var body = jsonEncode({
    'id_viagem': idViagem?.toString(),
    'id_login': idLogin?.toString(),
    'locations': locationList
  });

  var response = await http.post(
    Uri.parse(url),
    body: body,
    headers: {'Content-Type': 'application/json'},
  );

  if (response.statusCode == 200) {
    print('Locations sent successfully');
  } else {
    print('Failed to send locations. Status code: ${response.statusCode}');
  }
}

Future<void> iniciarBackgroundLocation() async {
  final service = FlutterBackgroundService();
  var isRunning = await service.isRunning();
  print("is running?: $isRunning");
  isRunning ? service.invoke("stopService") : service.startService();
  isRunning = await service.isRunning();
  print("is running after?: $isRunning");
  FlutterBackgroundService().invoke("setAsForeground");
}

Future<void> pararBackgroundLocation() async {
  final service = FlutterBackgroundService();
  var isRunning = await service.isRunning();
  print("is running?: $isRunning");
  service.invoke("stopService");
  isRunning = await service.isRunning();
  print("is running?: $isRunning");
}
