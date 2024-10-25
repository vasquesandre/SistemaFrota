<?php

include('../inc/conexao.php');

if (!isset($_SESSION)) {
    session_start();
}

$idLogin = $_SESSION['id_login'];
$idViagem = $_SESSION['id_viagem'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    $latlong = $_POST["latlong"];

    $atualizarMotorista = "UPDATE tb_login SET coordenadas = '$latlong' WHERE id_login = '$idLogin'";
    $resultAtualizarMotorista = mysqli_query($conn, $atualizarMotorista);
    if (!$resultAtualizarMotorista) {
        echo json_encode(array("status" => "error", "message" => "Erro ao atualizar coordenadas."));
        exit();
    }

    // insere coordenadas
    $insereCoordenadas = "INSERT INTO tb_coordenadas (id_viagem, coordenadas) VALUES ('$idViagem', '$latlong')";
    $resultCoordenadas = mysqli_query($conn, $insereCoordenadas);
    if (!$resultCoordenadas) {
        echo json_encode(array("status" => "error", "message" => "Coordenadas inseridas na viagem."));
    }

    echo json_encode(array("status" => "success", "message" => "Coordenadas salvas com sucesso!"));
} else {
    echo json_encode(array("status" => "error", "message" => "Método inválido para acessar esta página."));
}