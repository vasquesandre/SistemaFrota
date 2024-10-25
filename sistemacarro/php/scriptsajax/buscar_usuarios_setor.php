<?php

include ('../../inc/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $setor_id = $_POST['setor'];

    $query = "SELECT id_login, nome FROM tb_login WHERE setor = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $setor_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $token, $nome);

    $options = '';
    while (mysqli_stmt_fetch($stmt)) {
        $options .= '<option value="' . $token . '">' . $nome . '</option>';
    }

    mysqli_stmt_close($stmt);

    echo $options;
}