<?php

include('../../inc/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $query = "SELECT id_secretaria, nome_secretaria FROM tb_secretaria";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $secretaria_id, $secretaria_nome);

    $options = '';
    while (mysqli_stmt_fetch($stmt)) {
        $options .= '<option value="' . $secretaria_id . '">' . $secretaria_nome . '</option>';
    }

    mysqli_stmt_close($stmt);

    echo $options;
}