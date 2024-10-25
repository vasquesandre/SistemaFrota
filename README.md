# Sistema Frota

### _English Version_
This is a project I worked on during my internship; unfortunately, I couldn't finish it as I found another job.

Basically, it's a fleet and trip management system. First, we have a website built with PHP, JavaScript, CSS, and SASS, and a MySQL database. This site includes access levels, such as Administrators (who manage the system), Supervisors (who have access to manage vehicles, trips, and drivers), and Standard Users (who are the drivers). The system includes the registration of drivers, supervisors, and vehicles, a trip history that can be filtered by sector, driver, or vehicle used, and sector registration, where the supervisor can only view drivers from the same sector.

Finally, there’s an app built in Flutter, where the driver can start a trip using a vehicle previously registered and linked to them by their supervisor. The driver must enter the starting mileage and destination address. During the trip, supervisors can view the driver’s location, which is updated every 5 minutes. It’s worth noting that the location is captured every 30 seconds but saved in an array and sent every 5 minutes to reduce requests and, thus, use less mobile data. Upon arrival at the destination, the user only needs to enter the current mileage to end the trip. For this app, I didn’t need to focus on the iOS version since all the devices used are Android.

Once again, I’d like to mention that I didn’t get the chance to complete the project, but it was nearly finished. What was left was to refine some functions on both the website and app, and clean up the code, as several files in the commit were unnecessary for the system to function.

### _Portuguese Version_
Este é um projeto que realizei durante o meu período de estágio, infelizmente não consegui finalizá-lo pois arrumei outro trabalho.

Basicamente é um sistema de gerenciamento de frotas e viagens, primeiro temos um site feito em PHP, JavaScript, CSS e SCS e um banco de dados utilizando MySQL. Neste site temos níveis de acesso como Administradores (que gerenciam o sistema), Supervisores (que tem acesso para gerenciar os veículos, viagens e motoristas) e os Usuários Padrões (que são os motoristas). O sistema tem cadastramento de motoristas, supervisores e veículos, histórico de viagens que podem ser filtradas por setor, motorista ou pelo veículo utilizado, e também tem cadastro de setores, onde o supervisor só pode vizualizar os motoristas do mesmo setor.

Por fim temos um aplicativo feito em Flutter, onde nele o motorista pode iniciar a viagem utilizando um veículo previamente cadastrado e vinculado à ele por seu supervisor, sendo necessário inserir a quilometragem em que a viagem será iniciada e o endereço de destino, durante o percurso os supervisores poderão vizualizar sua localização que será atualizada a cada 5 minutos, ressaltando que a localização é obtida a cada 30 segundos, mas são salvas em um array e enviadas a cada 5 minutos visando reduzir as requests e assim consumindo menos dados móveis. Ao chegar no destino, o usuário apenas coloca a quilometragem atual para finalizar a viagem. Neste aplicativo eu não tive a necessidade de focar na versão em iOS pois os celulares a serem utilizados são todos Androids.

Ressaltando novamente que não tive a oportunidade de finalizar o projeto, mas estava praticamente no fim, o que faltou fazer foi arrumar algumas funções tanto no site quanto no aplicativo e também realizar a limpeza do código, pois vários arquivos presentes no commit não são necessários para o funcionamento do sistema.

## Technologies Used
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white) ![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E) ![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white) ![Flutter](https://img.shields.io/badge/Flutter-02569B?style=for-the-badge&logo=flutter&logoColor=white) ![Dart](https://img.shields.io/badge/Dart-0175C2?style=for-the-badge&logo=dart&logoColor=white)