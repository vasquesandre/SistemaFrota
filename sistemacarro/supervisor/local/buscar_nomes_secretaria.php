<?php

include ('../../inc/conexao.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $secretaria_id = $_SESSION['secretaria'];
    $status_viagem = 1;

    $query = "SELECT id_login, nome FROM tb_login WHERE secretaria = ? AND status_viagem = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $secretaria_id, $status_viagem);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $token, $nome);

    $options = '';
    while (mysqli_stmt_fetch($stmt)) {
        $options .= '<option value="' . $token . '">' . $nome . '</option>';
    }

    mysqli_stmt_close($stmt);

    echo $options;
}