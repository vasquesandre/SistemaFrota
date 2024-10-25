<?php

include ('../../inc/conexao.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $solicitador = $_SESSION['id_login'];
    $placa = $_POST['placa'];
    $novaSecretaria = $_POST['novaSecretariaVeiculo'];

    $resolvido = 0;
    $tipo = 4;

    date_default_timezone_set('America/Sao_Paulo');
    $datahora = date('Y-m-d H:i:s');

    $searchNomeSecretaria = "SELECT nome_secretaria FROM tb_secretaria WHERE id_secretaria = ?";
    $stmt = $conn->prepare($searchNomeSecretaria);
    $stmt->bind_param("i", $novaSecretaria);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nomeNovaSecretaria = $row['nome_secretaria'];

        $texto = $placa . " / " . $nomeNovaSecretaria;

        $sql = "INSERT INTO tb_solicitacoes (tipo, solicitador, texto, resolvido, data_solicitacao) VALUES (?, ?, ?, ?, ?)";
        $stmt2 = $conn->prepare($sql);
        $stmt2->bind_param("iisis", $tipo, $solicitador, $texto, $resolvido, $datahora);
        $stmt2->execute();
        
        if ($stmt2->affected_rows > 0) {
            echo json_encode(array("status" => "success", "message" => "Solicitação de alteração de secretaria do veículo enviada com sucesso."));
        } else {
            echo json_encode(array("status" => "error", "message" => "Não foi possível enviar a solicitação de alteração de secretaria do veículo, tente novamente."));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Não foi possível enviar a solicitação de alteração de secretaria do veículo, erro ao obter nome da secretaria, tente novamente."));
    }
}