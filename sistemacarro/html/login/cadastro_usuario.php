<?php
include('../../inc/conexao.php');
if (!isset($_SESSION)) {
  session_start();
}
include('../../inc/verifica_login.php');

$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$user = isset($_SESSION['user']) ? $_SESSION['user'] : '';
$mail = isset($_SESSION['mail']) ? $_SESSION['mail'] : '';
$office = isset($_SESSION['office']) ? $_SESSION['office'] : '';

echo '<script>
document.addEventListener("DOMContentLoaded", function() {
    var name = "' . $name . '";
    var user = "' . $user . '";
    var mail = "' . $mail . '";
    var office = "' . $office . '";
    document.getElementById("nome").value = name;
    document.getElementById("usuario").value = user;
    
    // Verifica se o campo mail está definido
    if (mail !== "") {
        document.getElementById("email").value = mail;
        document.getElementById("email").disabled = true; // Desabilita o campo mail
    } else {
        // Deixa o campo mail em branco apenas se não estiver definido
        document.getElementById("email").disabled = false; // Habilita o campo mail
    }
    
    // Verifica se o campo office está definido
    if (office !== "") {
        document.getElementById("matricula").value = office;
        document.getElementById("matricula").disabled = true; // Desabilita o campo office
    } else {
        // Deixa o campo office em branco apenas se não estiver definido
        document.getElementById("matricula").disabled = false; // Habilita o campo office
    }
});
</script>';



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
  lang="en"
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

    <title>Cadastro</title>

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

        <!-- Layout container -->
        <div class="layout-page" style="padding-left: 0;">

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4">Cadastro</h4>

              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Como é sua primeira vez neste sistema, é necessário concluir seu cadastro.</h5>
                    <hr class="my-0" />
                    <div class="card-body">
                      <form id="formAccountSettings" method="POST" action="processa_cadastro_usuario.php" onsubmit="return validarFormulario()">
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="nome" class="form-label">Nome</label>
                            <input
                              class="form-control"
                              type="text"
                              id="nome"
                              name="nome"
                              disabled
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="matricula" class="form-label">Matrícula</label>
                            <input class="form-control" type="number" name="matricula" id="matricula"  />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input
                              class="form-control"
                              type="email"
                              id="email"
                              name="email"
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="usuario" class="form-label">Nome de Usuário</label>
                            <input
                              type="text"
                              class="form-control"
                              id="usuario"
                              name="usuario"
                              disabled
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                              <label for="secretaria" class="form-label">Secretaria</label>
                              <select id="secretaria" class="form-select" name="secretaria" onchange="selecionarSecretaria()">
                                  <option value="default">Selecione a Secretaria</option>
                                  <?php
                                  $query = "SELECT id_secretaria, nome_secretaria FROM tb_secretaria";
                                  $result = mysqli_query($conn, $query);

                                  // Verifica se há resultados
                                  if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                      echo '<option value="' . $row['id_secretaria'] . '">' . $row['nome_secretaria'] . '</option>';
                                    }
                                  } else {
                                    echo '<option value="">Nenhuma secretaria encontrada</option>';
                                  }
                                  ?>
                              </select>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="setor">Setor</label>
                            <select name="setor" id="setor" class="form-select" id="defaultSelect" onchange="selecionarSetor()" disabled>
                              <option value="default">Selecione o Setor</option>
                            </select>
                          </div>
                        </div>
                        <div class="mt-2">
                          <button type="submit" id="submitBtn" class="btn btn-primary me-2" disabled>Salvar Alterações</button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <?php
            include('../../inc/footer.php');
            ?>

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
    <script src="../../assets/js/pages-account-settings-account.js"></script>
    <script src="login.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>