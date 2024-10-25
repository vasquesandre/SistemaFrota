<?php

include ('../inc/conexao.php');

session_start();

$response = array();

if (isset($_POST['username']) && ($_POST['password'] !== "")) {
    $ldap_server = "192.168.255.4";
    $ldap_porta = "389";
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

    $ldapconn = ldap_connect($ldap_server, $ldap_porta) or die("Could not connect to LDAP server.");
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

    if ($ldapconn) {
        $bind = ldap_bind($ldapconn, $user_domain, $ldap_pass);

        if ($bind) {
            $result = ldap_search($ldapconn, $ldaptree, $filter, $attributes) or die("Error in search query: " . ldap_error($ldapconn));
            $data = ldap_get_entries($ldapconn, $result);

            if (isset($data[0])) {
                $result = $data[0];
                $user = $result["samaccountname"][0];

                $_SESSION['user'] = $user;

                $verificaCadastro = "SELECT id_login, nome, matricula, status_viagem FROM tb_login WHERE usuario = ?";
                $stmt = mysqli_prepare($conn, $verificaCadastro);
                mysqli_stmt_bind_param($stmt, "s", $user);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $id_login, $nome, $matricula, $status_viagem);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);

                if ($id_login) {

                    if ($status_viagem == 1) {
                        $selectIdViagem = "SELECT id_viagem FROM tb_viagem WHERE id_login = ? ORDER BY datahora DESC LIMIT 1";
                        $stmt = mysqli_prepare($conn, $selectIdViagem);
                        mysqli_stmt_bind_param($stmt, "i", $id_login);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $id_viagem);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_close($stmt);

                        
                        http_response_code(200);
                        $response['id_login'] = $id_login;
                        $response['nome'] = $nome;
                        $response['matricula'] = $matricula;
                        $response['id_viagem'] = $id_viagem;

                    } else {
                        http_response_code(200);
                        $response['id_login'] = $id_login;
                        $response['nome'] = $nome;
                        $response['matricula'] = $matricula;
                    }

                } else {
                    http_response_code(201);
                    $response['message'] = 'Usuário não cadastrado';
                }
            } else {
                http_response_code(201);
                $response['message'] = 'Erro ao buscar usuário LDAP';
            }
        } else {
            http_response_code(201);
            $response['message'] = 'Credenciais inválidas';
        }
    } else {
        http_response_code(201);
        $response['message'] = 'Não foi possível conectar ao servidor LDAP';
    }
} else {
    http_response_code(201);
    $response['message'] = 'Credenciais não fornecidas';
}

echo json_encode($response);
