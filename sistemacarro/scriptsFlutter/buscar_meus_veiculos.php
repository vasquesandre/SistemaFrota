<?php
include('../inc/conexao.php');

// Verifica se a solicitação é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o id_login foi passado no corpo da solicitação
    

    // Obtém o id_login do corpo da solicitação
    $idLogin = $_POST['id_login'];

    // Prepara a consulta SQL para selecionar os veículos associados ao id_login
    $sql = "SELECT lc.id_veiculo, c.placa, c.modelo FROM tb_login_veiculo lc 
            INNER JOIN tb_veiculo c ON c.id_veiculo = lc.id_veiculo
            WHERE lc.id_login = ?
            ORDER BY c.placa ASC";

    // Prepara a declaração SQL
    $stmt = $conn->prepare($sql);

    // Vincula o parâmetro id_login à declaração SQL
    $stmt->bind_param("i", $idLogin);

    // Executa a consulta SQL
    $stmt->execute();

    // Obtém o resultado da consulta
    $result = $stmt->get_result();

    // Inicializa um array para armazenar as opções
    $opcoes = array();

    // Itera sobre o resultado da consulta e adiciona as opções ao array
    while ($row = $result->fetch_assoc()) {
        $opcoes[] = array(
            'id_veiculo' => $row['id_veiculo'],
            'placa' => $row['placa'],
            'modelo' => $row['modelo']
        );
    }

    // Envia a resposta JSON com as opções para o Flutter
    http_response_code(200);
    echo json_encode($opcoes);
} else {
    // Se a solicitação não for do tipo POST, envie uma resposta indicando método não permitido
    http_response_code(405);
    echo json_encode(array('message' => 'Método não permitido'));
}