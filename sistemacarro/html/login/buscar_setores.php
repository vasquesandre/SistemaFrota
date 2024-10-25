<?php

include ('../../inc/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $secretaria_id = $_POST['secretaria'];

    $query = "SELECT id_setor, nome_setor FROM tb_setor WHERE id_secretaria = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $secretaria_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $setor_id, $setor_nome);

    $options = '';
    while (mysqli_stmt_fetch($stmt)) {
        $options .= '<option value="' . $setor_id . '">' . $setor_nome . '</option>';
    }

    mysqli_stmt_close($stmt);

    echo $options;
}