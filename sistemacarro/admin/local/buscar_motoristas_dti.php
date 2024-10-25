<?php

include ('../../inc/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $setor = "DTI";
    $status_viagem = 1;

    $query = "SELECT l.id_login, l.nome, l.setor FROM tb_login l
            INNER JOIN tb_setor s ON l.setor = s.id_setor
            WHERE s.nome_setor LIKE ?
            AND status_viagem = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    $setor_param = "%" . $setor . "%";

    mysqli_stmt_bind_param($stmt, "si", $setor_param, $status_viagem);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $token, $nome, $setor);

    $options = '';
    while (mysqli_stmt_fetch($stmt)) {
        $options .= '<option value="' . $token . '">' . $nome . '</option>';
    }

    mysqli_stmt_close($stmt);

    echo $options;
}
