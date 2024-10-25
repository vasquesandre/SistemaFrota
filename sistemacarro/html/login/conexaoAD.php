<?php

include ('../../inc/conexao.php');

session_start();

if (isset($_POST['username']) && ($_POST['password'] !== "")) {
    $ldap_servers = [
        ["ip" => "192.168.255.7", "porta" => "389"],
        ["ip" => "192.168.255.5", "porta" => "389"],
        ["ip" => "192.168.255.4", "porta" => "389"]
    ];
    
    $base_dn = '(&(objectCategory=person)(objectClass=user))';
    $ldaptree = "DC=jacarei,DC=local";
    $dominio = "@jacarei.local";
    $username = $_POST['username'];
    $username = preg_replace('/[^a-z.]/', '', $username);
    $username = strtolower($username);
    $username = trim($username);
    $user_domain = $username . $dominio;
    $ldap_pass = $_POST['password'];
    $filter = "(sAMAccountName=" . $username . "*)";
    $attributes = array('name', 'sAMAccountName', 'mail', 'physicalDeliveryOfficeName');

    $ldapconn = null;

    foreach ($ldap_servers as $server) {
        $ldapconn = ldap_connect($server["ip"], $server["porta"]);
        if ($ldapconn) {
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

            $bind = ldap_bind($ldapconn, $user_domain, $ldap_pass);
            if ($bind) {
                break; // Conectado e autenticado com sucesso, sair do loop
            }
        }
        $ldapconn = null; // Resetar conexão para tentar o próximo servidor
    }

    if ($ldapconn && $bind) {
        $result = ldap_search($ldapconn, $ldaptree, $filter, $attributes) or die("Error in search query: " . ldap_error($ldapconn));
        $data = ldap_get_entries($ldapconn, $result);

        if (isset($data[0])) {
            $result = $data[0];
            $name = $result["name"][0];
            $user = $result["samaccountname"][0];
            $mail = isset($result["mail"][0]) ? $result["mail"][0] : '';
            $office = isset($result["physicaldeliveryofficename"][0]) ? $result["physicaldeliveryofficename"][0] : '';
            $office = preg_replace('/[^0-9]/', '', $office);

            $_SESSION['name'] = $name;
            $_SESSION['user'] = $user;
            if ($mail !== '') {
                $_SESSION['mail'] = $mail;
            }
            if ($office !== '') {
                $_SESSION['office'] = $office;
            }

            $verificaCadastro = "SELECT COUNT(usuario) as total FROM tb_login WHERE usuario = ?";
            $stmt = mysqli_prepare($conn, $verificaCadastro);
            mysqli_stmt_bind_param($stmt, "s", $user);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $totalUsuarios);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            if ($totalUsuarios > 0) {
                $salvarSecretaria = "SELECT l.secretaria, l.setor, l.id_perfil, p.nome_perfil FROM tb_login l
                                    INNER JOIN tb_perfil p ON p.id_perfil = l.id_perfil
                                    WHERE l.usuario = ?";
                $stmt = mysqli_prepare($conn, $salvarSecretaria);
                mysqli_stmt_bind_param($stmt, "s", $user);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $secretaria, $setor, $id_perfil, $nome_perfil);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);

                $_SESSION['secretaria'] = $secretaria;
                $_SESSION['setor'] = $setor;
                $_SESSION['id_perfil'] = $id_perfil;
                $_SESSION['nome_perfil'] = $nome_perfil;

                header("Location: ../../index.php");
                exit();
            } else {
                header("Location: cadastro_usuario.php");
                exit();
            }
        } else {
            header("Location: login.php?msg=error");
            exit();
        }
    } else {
        header("Location: login.php?msg=invalid");
        exit();
    }
}
