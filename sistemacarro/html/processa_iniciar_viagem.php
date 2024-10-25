<?php

include ('../inc/conexao.php');

if (!isset($_SESSION)) {
    session_start();
}

$idLogin = $_SESSION['id_login'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    $veiculo = $_POST["veiculo"];
    $km = $_POST["km"];
    $destino = $_POST["destino"];
    $latlong = $_POST["latlong"];
    $datahora = date('Y-m-d H:i:s');

    // atualiza coordendas e status de viagem
    $atualizarCoordenadas = "UPDATE tb_login SET coordenadas = '$latlong', status_viagem = 1 WHERE id_login = '$idLogin'";
    $resultAtualizarCoordenadas = mysqli_query($conn, $atualizarCoordenadas);
    if (!$resultAtualizarCoordenadas) {
        echo json_encode(array("status" => "error", "message" => "Erro ao atualizar coordenadas."));
        exit();
    }

    // cria nova viagem
    // cria nova viagem
    $criarViagem = "INSERT INTO tb_viagem (id_login, id_veiculo, km_inicial, destino, datahora) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($criarViagem);
    $stmt->bind_param("iisss", $idLogin, $veiculo, $km, $destino, $datahora);
    $stmt->execute();
    if ($stmt->affected_rows < 1) {
        echo json_encode(array("status" => "error", "message" => "Erro ao criar nova viagem: " . $conn->error)); // Adicionando detalhes do erro MySQL
        exit();
    }

    // Recupera o ID da viagem recém-criada
    $idViagem = mysqli_insert_id($conn);
    $_SESSION['id_viagem'] = $idViagem;

    echo json_encode(array("status" => "success", "message" => "Viagem criada com sucesso. ID da viagem: " . $idViagem));


} else {
    echo json_encode(array("status" => "error", "message" => "Método inválido para acessar esta página."));
}