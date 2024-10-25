<?php

include ('../../inc/verifica_acesso_supervisor.php');

?>

<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="pt-br"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Histórico de Viagens</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Links do Mapa -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <?php
        include ('../../inc/sidebar.php');
        ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <?php
          include ('../../inc/navbar.php');
          ?>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-xl">
                    <div class="nav-align-top mb-4">
                        <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link active"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#historicomotoristas"
                            aria-controls="historicomotoristas"
                            aria-selected="false"
                            >
                             Histórico dos Motoristas
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#historicoveiculos"
                            aria-controls="historicoveiculos"
                            aria-selected="false"
                            onclick="buscarVeiculos()"
                            >
                             Histórico dos Veículos
                            </button>
                        </li>
                        </ul>
                        
                          <div class="tab-content col-xl" style="padding: 0; background: none; box-shadow: none;">
                              <div class="tab-pane fade show active" id="historicomotoristas" role="tabpanel">
                              <div class="row">
                                <div class="col-xl">
                                    <div class="card mb-4">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Histórico Geral dos Motoristas</h5>
                                        </div>
                                        <div class="card-body">
                                        <div class="mb-3">
                                            <label for="setor" class="form-label">selecione caso queira especificar um setor</label>
                                            <select id="setor" class="form-select" onchange="buscarNomes()">
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="usuario" class="form-label">Motoristas em atividade</label>
                                            <select id="usuario" class="form-select" onchange="buscarViagensUsuario()">
                                            </select>
                                        </div>
                                        <div class="mt-3">
                                            <div class="row">
                                              <div class="col-12 mb-3 mb-md-0">
                                                  <label for="viagens" class="form-label">Selecione uma viagem para ver suas coordenadas</label>
                                                  <div class="list-group" id="viagens">
                                                  </div>
                                              </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                              </div>
                              <div class="tab-pane fade" id="historicoveiculos" role="tabpanel">
                              <div class="row">
                                <div class="col-xl">
                                    <div class="card mb-4">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Histórico Geral dos Veículos</h5>
                                        </div>
                                        <div class="card-body">
                                        <div class="mb-3">
                                            <label for="veiculos" class="form-label">Selecione um Veículo</label>
                                            <select id="veiculos" class="form-select" onchange="buscarViagensVeiculo()">
                                              <option value="default">--</option>
                                            </select>
                                        </div>
                                        <div class="mt-3">
                                            <div class="row">
                                            <div class="col-12 mb-3 mb-md-0">
                                                <label for="viagensveiculo" class="form-label">Selecione uma viagem para ver suas informações</label>
                                                <div class="list-group" id="viagensveiculo">
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                              </div>
                              </div>
                              </div>
                        </div>
                <div class="col-xl">
                    <div class="nav-align-top mb-4">
                        <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link active"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#historicomotoristas"
                            aria-controls="historicomotoristas"
                            aria-selected="false"
                            >
                             Mapa
                            </button>
                        </li>
                        </ul>
                        
                          <div class="tab-content col-xl" style="padding: 0; background: none; box-shadow: none;">
                              <div class="tab-pane fade show active" id="historicomotoristas" role="tabpanel">
                              <div class="row">
                                <div class="col-xl">
                                <div class="card mb-4">
                                  <div class="card-header">
                                      <div class="card-body">
                                      <div>
                                        <div style="height: 400px;" id="map"></div>
                                        <script>
                                          var map = L.map('map', {
                                            center: [-23.306353, -45.9760295],
                                            zoom: 17
                                          });
                                          L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                            maxZoom: 19,
                                            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                                          }).addTo(map);
                                        </script>
                                      </div>
                                      <div id="description" class="mt-3">

                                      </div>
                                    </div>
                                  </div>
                                  <div class="card-body">
                    
                                  </div>
                              </div>
                                </div>
                                </div>
                              </div>
                            
                              </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <!-- / Content -->

            <!-- Footer -->
            <?php
            include ('../../inc/footer.php');
            ?>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="./historico_viagens.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
  </body>
</html>