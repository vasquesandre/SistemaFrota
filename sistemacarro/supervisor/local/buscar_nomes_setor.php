<?php

include ('../../inc/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $setor_id = $_POST['setor'];
    $status_viagem = 1;

    $query = "SELECT id_login, nome FROM tb_login WHERE setor = ? AND status_viagem = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $setor_id, $status_viagem);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $token, $nome);

    $options = '';
    while (mysqli_stmt_fetch($stmt)) {
        $options .= '<option value="' . $token . '">' . $nome . '</option>';
    }

    mysqli_stmt_close($stmt);

    echo $options;
}