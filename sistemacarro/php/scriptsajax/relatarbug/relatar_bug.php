<?php

include ('../../../inc/conexao.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $texto = mysqli_real_escape_string($conn, $_POST['textoProblema']);

    date_default_timezone_set('America/Sao_Paulo');
    $datahora = date('Y-m-d H:i:s');

    $tipo = 2;

    $solicitador = $_SESSION['id_login'];

    $resolvido = 0;

    $sql = "INSERT INTO tb_solicitacoes (tipo, solicitador, texto, resolvido, data_solicitacao) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisis", $tipo, $solicitador, $texto, $resolvido, $datahora);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(array("status" => "success", "message" => "Problema enviado com sucesso."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Não foi possível enviar o problema, tente novamente."));
    }
}