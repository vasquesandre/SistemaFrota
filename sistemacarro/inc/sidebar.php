<?php

include ('conexao.php');

if (!isset($_SESSION)) {
  session_start();
}

$user = $_SESSION['user'];
$name = $_SESSION['name'];
$nome_perfil = $_SESSION['nome_perfil'];

$getUserId = "SELECT id_login FROM tb_login WHERE usuario = '$user'";
$resultUserId = mysqli_query($conn, $getUserId);
$row = mysqli_fetch_assoc($resultUserId);
$idLogin = $row['id_login'];
$_SESSION['id_login'] = $idLogin;

if ($nome_perfil == 'Supervisor') {
  echo '<style> #admin, #usuariopadrao { display: none; } </style>';
} else if ($nome_perfil == 'Usuário Padrão') {
  echo '<style> #admin, #supervisor { display: none; } </style>';
}

?>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
          <a href="index.html" class="app-brand-link">
  <img src="../assets/img/frotahorizontal.png" alt="">
</a>


            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item pagina">
              <a href="../../../../sistemacarro/html/home.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Home</div>
              </a>
            </li>
            
            <li class="menu-header small text-uppercase" id="admin">
              <span class="menu-header-text">Admin</span>
            </li>
            <li class="menu-item pagina-dropdown" id="admin">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-current-location"></i>
                <div data-i18n="Localização">Localização</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item pagina">
                  <a href="../../../../sistemacarro/admin/local/localizacaoDTI.php" class="menu-link">
                    <div data-i18n="Localização DTI">Localização DTI</div>
                  </a>
                </li>
                <li class="menu-item pagina">
                  <a href="../../../../sistemacarro/admin/local/localizacaoGeral.php" class="menu-link">
                    <div data-i18n="Localização Geral">Localização Geral</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item pagina" id="admin">
              <a href="../../../../sistemacarro/admin/viagens/historico_viagens.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-trip"></i>
                <div data-i18n="Authentications">Histórico de Viagens</div>
              </a>
            </li>
            <li class="menu-item pagina" id="admin">
              <a href="../../../../sistemacarro/admin/gerenciarveiculos/gerenciamento_veiculos.php" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-car-garage"></i>
                <div data-i18n="Authentications">Gerenciar Veiculos</div>
              </a>
            </li>
            <li class="menu-item pagina" id="admin">
              <a href="../../../../sistemacarro/admin/gerenciamento/gerenciamento.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Authentications">Gerenciar Usuários</div>
              </a>
            </li>
            <li class="menu-item pagina" id="admin">
              <a href="../../../../sistemacarro/admin/search/pesquisar_usuarios.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Pesquisar Usuários">Pesquisar Usuários</div>
              </a>
            </li>
            <li class="menu-item pagina" id="admin">
              <a href="../../../../sistemacarro/admin/solicitacoes/solicitacoes.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-notification"></i>
                <div data-i18n="Authentications">Solicitações</div>
              </a>
            </li>


            <li class="menu-header small text-uppercase" id="supervisor">
              <span class="menu-header-text">supervisor</span>
            </li>
            <li class="menu-item pagina" id="supervisor">
              <a href="../../../../sistemacarro/supervisor/local/localizacaoGeral.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-current-location"></i>
                <div data-i18n="Authentications">Localização</div>
              </a>
            </li>
            <li class="menu-item pagina" id="supervisor">
              <a href="../../../../sistemacarro/supervisor/viagens/historico_viagens.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-trip"></i>
                <div data-i18n="Authentications">Histórico de Viagens</div>
              </a>
            </li>
            <li class="menu-item pagina" id="supervisor">
              <a href="../../../../sistemacarro/supervisor/gerenciarveiculos/gerenciamento_veiculos.php" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-car-garage"></i>
                <div data-i18n="Authentications">Gerenciar Veiculos</div>
              </a>
            </li>
            <li class="menu-item pagina" id="supervisor">
              <a href="../../../../sistemacarro/supervisor/gerenciamento/gerenciamento.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Authentications">Gerenciar Usuários</div>
              </a>
            </li>
            <li class="menu-item pagina" id="supervisor">
              <a href="../../../../sistemacarro/supervisor/search/pesquisar_usuarios.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Pesquisar Usuários">Pesquisar Usuários</div>
              </a>
            </li>
            <li class="menu-item pagina" id="supervisor">
              <a href="../../../../sistemacarro/supervisor/solicitacoes/solicitacoes.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-notification"></i>
                <div data-i18n="Authentications">Solicitações</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase" id="usuariopadrao">
              <span class="menu-header-text">usuario padrão</span>
            </li>
            <li class="menu-item pagina" id="usuariopadrao">
              <a href="../../../../sistemacarro/usuariopadrao/solicitacoes/solicitacoes.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-notification"></i>
                <div data-i18n="Authentications">Solicitações</div>
              </a>
            </li>


            <li class="menu-header small text-uppercase" id="admin">
              <span class="menu-header-text">Telas</span>
            </li>
            <li class="menu-item pagina" id="admin">
              <a href="../../../../sistemacarro/html/login/cadastro_usuario.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-plus"></i>
                <div data-i18n="Authentications">Novo Usuário</div>
              </a>
            </li>
            <li class="menu-item pagina" id="admin">
              <a href="../../../../sistemacarro/html/login/login.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-plus"></i>
                <div data-i18n="Authentications">Login</div>
              </a>
            </li>
            <li class="menu-item pagina" id="admin">
              <a href="../../../../sistemacarro/html/setores/setores.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-plus"></i>
                <div data-i18n="Authentications">Setores</div>
              </a>
            </li>
            <li class="menu-item pagina" id="admin">
              <a href="../../../../sistemacarro/html/secretarias/secretarias.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-plus"></i>
                <div data-i18n="Authentications">Secretarias</div>
              </a>
            </li>
            <li class="menu-item pagina" id="admin">
              <a href="../../../../sistemacarro/html/iniciar_viagem.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-plus"></i>
                <div data-i18n="Authentications">Iniciar Viagem</div>
              </a>
            </li>
            <li class="menu-item pagina" id="admin">
              <a href="../../../../sistemacarro/html/finalizar_viagem.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-plus"></i>
                <div data-i18n="Authentications">Finalizar Viagem</div>
              </a>
            </li>
          </ul>
        </aside>