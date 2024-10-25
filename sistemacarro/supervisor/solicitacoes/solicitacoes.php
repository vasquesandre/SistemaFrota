<?php

include ('../../inc/conexao.php');


$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';

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

    <title>Home</title>

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
            include ('../../php/includes/modal_confirm.php');
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
                                    <h5 class="card-header">Solicitações de vínculo de veículos</h5>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-hover" id="tabelaVeiculoNaoResolvido">
                                            <thead>
                                            <tr>
                                                <th>Solicitador</th>
                                                <th>setor solicitador</th>
                                                <th>veículo que será vinculado</th>
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
                                    <h5 class="card-header">Solicitações de alteração de veículos</h5>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-hover" id="tabelaVeiculoResolvido">
                                            <thead>
                                            <tr>
                                                <th>Solicitador</th>
                                                <th>setor solicitador</th>
                                                <th>veículo que será vinculado</th>
                                                <th>data solicitação</th>
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
            <div class="row">
                <div class="col-xl">
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">Solicitar alteração de setor do usuário</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="row g-2">
                                <div class="mb-3 col-md-4">
                                    <label for="matricula" class="form-label">Digite a matrícula de quem vai ser alterado</label>
                                    <input id="matricula" class="form-control" type="number" placeholder="Matrícula" oninput="buscarNome()"/>
                                    <em id="nomeEncontrado"></em>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="secretaria" class="form-label">secretaria para qual será movido</label>
                                    <select id="secretaria" class="form-select" name="secretaria" onchange="selecionarSecretaria(), atualizarSetores()" disabled>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label" for="setor">setor para qual será movido</label>
                                    <select name="setor" id="setor" class="form-select" id="defaultSelect"
                                        onchange="selecionarSetor()" disabled>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="saveBtn" class="btn btn-primary" disabled><a style="text-decoration: none; color: white;" onclick="enviarSolicitacaoSetor()">Enviar Solicitação</a></button>
                    </div>
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl">
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">Solicitar alteração de secretaria do veículo</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="row g-2">
                                <div class="mb-3 col-md-6">
                                    <label for="placa_veiculo" class="form-label">Digite a placa do veículo que será alterado</label>
                                    <div class="form-check form-switch mb-1 float-end">
                                        <label class="form-check-label" for="flexSwitchCheckChecked"
                                        >Placa Mercosul</label
                                        >
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked />
                                    </div>
                                    <input id="placa_veiculo" class="form-control" type="text" placeholder="___-____" oninput="verificarVeiculo()"/>
                                    <em id="veiculoEncontrado"></em>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="secretaria_veiculo" class="form-label">secretaria para qual será movido</label>
                                    <select id="secretaria_veiculo" class="form-select" name="secretaria_veiculo" onchange="selecionarSecretaria()" disabled>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="veiculoBtn" class="btn btn-primary" disabled><a style="text-decoration: none; color: white;" onclick="enviarAlteracaoSecretariaVeiculo()">Enviar Solicitação</a></button>
                    </div>
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl">
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">Relatar problema ou bug</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Descreva o problema ou bug, onde ele está, como ele acontece, etc.</label>
                            <textarea
                            type="text"
                            class="form-control"
                            id="textoProblema"
                            aria-describedby="basic-addon-search31"
                            oninput="checarTexto()"
                            ></textarea>
                            <div id="caracteres" class="form-text">
                                0/500
                            </div>
                        </div>
                        <button type="button" id="problemBtn" class="btn btn-primary" onclick="enviarProblema()" disabled><a style="text-decoration: none; color: white;">Enviar Problema</a></button>
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

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../../assets/js/ui-toasts.js"></script>
    <script src="./solicitacoes.js"></script>
    <script src="../../assets/js/alterarSetor.js"></script>
    <script src="../../assets/js/buscarnome/buscar_nome.js"></script>
    <script src="../../assets/js/vincularveiculo/vincular_veiculo.js"></script>
    <script src="../../assets/js/solicitacoes/solicitacao_resolvida.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    
    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>