<?php

include ('../../inc/conexao.php');

session_start();

$perfil = $_SESSION['id_perfil'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($perfil == 1) {
        $secretaria_id = $_POST['secretaria'];

        $query = "SELECT id_login, nome FROM tb_login WHERE secretaria = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $secretaria_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $token, $nome);

        $options = '';
        while (mysqli_stmt_fetch($stmt)) {
            $options .= '<option value="' . $token . '">' . $nome . '</option>';
        }

        mysqli_stmt_close($stmt);

        echo $options;
    } else {
        $secretaria_id = $_SESSION['secretaria'];

        $query = "SELECT id_login, nome FROM tb_login WHERE secretaria = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $secretaria_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $token, $nome);

        $options = '';
        while (mysqli_stmt_fetch($stmt)) {
            $options .= '<option value="' . $token . '">' . $nome . '</option>';
        }

        mysqli_stmt_close($stmt);

        echo $options;
    }
}