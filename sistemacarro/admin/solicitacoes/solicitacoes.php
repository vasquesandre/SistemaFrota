<?php

include ('../../inc/verifica_acesso_admin.php');

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

    <title>Solicitações</title>

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

            <?php
            include ('../../php/includes/toast_message.php');
            ?>
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
                            data-bs-target="#naoResolvidos"
                            aria-controls="naoResolvidos"
                            aria-selected="false"
                            onclick="carregarNaoResolvidos()"
                            >
                            Não Resolvidos
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                            type="button"
                            class="nav-link"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#resolvidos"
                            aria-controls="resolvidos"
                            aria-selected="false"
                            onclick="carregarResolvidos()"
                            >
                            Resolvidos
                            </button>
                        </li>
                        </ul>
                        
                        <div class="tab-content col-xl" style="padding: 0; background: #fff0; box-shadow: none;">
                            <div class="tab-pane fade show active" id="naoResolvidos" role="tabpanel">
                                <div class="card">
                                    <h5 class="card-header">Solicitações de vínculo de veículo</h5>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-hover" id="tabelaVinculoVeiculoNaoResolvido">
                                            <thead>
                                            <tr>
                                                <th>Solicitador / setor</th>
                                                <th>VEÍCULO QUE SERÁ VINCULADO</th>
                                                <th>data solicitação</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                            </tbody>
                                        </table>
                                    </div>
                                </div> 
                                <div class="card mt-5">
                                    <h5 class="card-header">Solicitações de alteração de setor</h5>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-hover" id="tabelaSetorNaoResolvido">
                                            <thead>
                                            <tr>
                                                <th>Solicitador</th>
                                                <th>será alterado</th>
                                                <th>secretaria / setor de destino</th>
                                                <th>data solicitação</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                            </tbody>
                                        </table>
                                    </div>
                                </div> 
                                <div class="card mt-5">
                                    <h5 class="card-header">Solicitações de alteração de secretaria de veículo</h5>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-hover" id="tabelaAlterarSecretariaVeiculoNaoResolvido">
                                            <thead>
                                            <tr>
                                                <th>Solicitador</th>
                                                <th>Veiculo / secretaria de destino</th>
                                                <th>data solicitação</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                            </tbody>
                                        </table>
                                    </div>
                                </div> 
                                <div class="card mt-5">
                                    <h5 class="card-header">Solicitações de problemas ou bugs</h5>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-hover" id="tabelaBugNaoResolvido">
                                            <thead>
                                            <tr>
                                                <th>Solicitador</th>
                                                <th>solicitação</th>
                                                <th>data solicitação</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                            </tbody>
                                        </table>
                                    </div>
                                </div> 
                            </div>
                            <div class="tab-pane fade" id="resolvidos" role="tabpanel">
                                <div class="card">
                                    <h5 class="card-header">Solicitações de vínculo de veículo</h5>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-hover" id="tabelaVinculoVeiculoResolvido">
                                            <thead>
                                            <tr>
                                                <th>Solicitador / setor</th>
                                                <th>VEÍCULO QUE foi VINCULADO</th>
                                                <th>data solicitação</th>
                                                <th>resolvido em / por</th>
                                            </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                            </tbody>
                                        </table>
                                    </div>
                                </div> 
                                <div class="card mt-5">
                                    <h5 class="card-header">Solicitações de alteração de setor</h5>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-hover" id="tabelaSetorResolvido">
                                            <thead>
                                            <tr>
                                                <th>solicitador</th>
                                                <th>alterado</th>
                                                <th>secretaria / setor de destino</th>
                                                <th>data solicitação</th>
                                                <th>resolvido em / por</th>
                                            </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card mt-5">
                                    <h5 class="card-header">Solicitações de alteração de secretaria de veículo</h5>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-hover" id="tabelaAlterarSecretariaVeiculoResolvido">
                                            <thead>
                                            <tr>
                                                <th>Solicitador</th>
                                                <th>Veiculo / secretaria de destino</th>
                                                <th>data solicitação</th>
                                                <th>resolvido em / por</th>
                                            </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card mt-5">
                                    <h5 class="card-header">Solicitações de problemas ou bugs</h5>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-hover" id="tabelaBugResolvido">
                                            <thead>
                                            <tr>
                                                <th>solicitador</th>
                                                <th>solicitação</th>
                                                <th>data solicitação</th>
                                                <th>resolvido em / por</th>
                                            </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                            </tbody>
                                        </table>
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
    <script src="./solicitacoes.js"></script>
    <script src="../../assets/js/vincularveiculo/vincular_veiculo.js"></script>
    <script src="../../assets/js/solicitacoes/solicitacao_resolvida.js"></script>
    <script src="../../assets/js/ui-toasts.js"></script>
    <script src="../../assets/js/ui-popover.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
  </body>
</html>