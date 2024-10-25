<?php

include ('../../inc/conexao.php');

include ('../../inc/verifica_acesso_supervisor.php');

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
    <link rel="stylesheet" href="../../assets/css/veiculos.css">

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
            include('../../php/includes/toast_message.php');
            include('../../php/includes/modal_setor.php');
            include('../../php/includes/modal_confirm.php');
            include('../../php/includes/modal_vincular_veiculo.php');
            ?>
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-xl">
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">Aqui é possível pesquisar e alterar informações de um usuário.</h5>
                    </div>
                    <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Matricula</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                                    <input
                                    type="number"
                                    class="form-control"
                                    id="numeroMatricula"
                                    placeholder="Search..."
                                    aria-label="Search..."
                                    aria-describedby="basic-addon-search31"
                                    required
                                    autofocus
                                    />
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary"><a style="text-decoration: none; color: white;" onclick="pesquisarUsuario()">Pesquisar Usuário</a></button>


                        <div class="col-md-3" style="display: none;">
                          <label class="form-label" for="showToastPlacement">&nbsp;</label>
                          <button type="button" id="showToastPlacement" class="btn btn-primary d-block">Success</button>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl">
                  <div class="card mb-4 infos">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">Informações</h5>
                    </div>
                    <div class="card-body" id="success" style="display: none;">
                        <div class="mb-3">
                          <label class="form-label" for="nome">Nome</label>
                          <input type="text" class="form-control" id="nome" readonly/>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="usuario">Usuario</label>
                          <input type="text" class="form-control" id="usuario" readonly/>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="email">Email</label>
                          <div class="input-group input-group-merge">
                            <input
                              type="text"
                              id="email"
                              class="form-control"
                              aria-describedby="basic-default-email2"
                              readonly
                            />
                          </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="matricula_usuario">Matricula</label>
                          <input
                            type="number"
                            id="matricula_usuario"
                            class="form-control"
                            readonly
                          />
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="nomesecretaria">Secretaria</label>
                          <input type="text" class="form-control" id="nomesecretaria" readonly/>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="nomesetor">Setor</label>
                          <input type="text" class="form-control" id="nomesetor" readonly/>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="perfil">Perfil</label>
                          <input type="text" class="form-control" id="perfil" readonly/>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="perfil">Veiculos</label>
                          <div id="meusVeiculos">

                          </div>
                        </div>
                        <div class="demo-inline-spacing">
                          <div class="btn-group me-1" id="alterarSetorBtn">
                          </div>
                          <div class="btn-group" id="alterarAtivoBtn">
                          </div>
                          <div class="btn-group" id="vincularVeiculoBtn">
                          </div>
                        </div>
                    </div>
                    <div class="card-body" id="error" style="display: none; padding-top: 0;">
                        <input type="text" class="form-control-plaintext" id="errorMessage" control-id="ControlID-6" readonly>
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
    <script src="../../inc/sidebar.js"></script>
    <script src="../../assets/js/ui-toasts.js"></script>
    <script src="./pesquisar_usuarios.js"></script>
    <script src="../../assets/js/alterarSetor.js"></script>
    <script src="../../assets/js/alterarNivel.js"></script>
    <script src="../../assets/js/ativoUsuario.js"></script>
    <script src="../../assets/js/vincularveiculo/vincular_veiculo.js"></script>
    <script src="../../assets/js/desvincularveiculo/desvincular_veiculo.js"></script>
    <script src="../../assets/js/buscarnome/buscar_nome.js"></script>
    <script src="../../assets/js/buscarveiculosusuario/buscar_veiculos_usuario.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    
    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>