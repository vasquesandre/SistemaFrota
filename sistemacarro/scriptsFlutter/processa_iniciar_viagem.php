<?php

include ('../inc/conexao.php');

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idLogin = $_POST['id_login'];
    $veiculo = $_POST["veiculo"];
    $km = $_POST["km"];
    $destino = $_POST["destino"];
    $latlong = $_POST["latlong"];

    date_default_timezone_set('America/Sao_Paulo');
    $datahora = date('Y-m-d H:i:s');

    // atualiza coordendas e status de viagem
    $atualizarCoordenadas = "UPDATE tb_login SET coordenadas = '$latlong', status_viagem = 1 WHERE id_login = '$idLogin'";
    $resultAtualizarCoordenadas = mysqli_query($conn, $atualizarCoordenadas);
    if (!$resultAtualizarCoordenadas) {
        http_response_code(500);
        $response['message'] = 'Não foi possível iniciar a viagem.';
        exit();
    }

    // cria nova viagem
    $criarViagem = "INSERT INTO tb_viagem (id_login, id_veiculo, km_inicial, destino, datahora) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($criarViagem);
    $stmt->bind_param("iisss", $idLogin, $veiculo, $km, $destino, $datahora);
    $stmt->execute();
    if ($stmt->affected_rows < 1) {
        http_response_code(500);
        $response['message'] = 'Não foi possível iniciar a viagem.';
        exit();
    }

    $idViagem = mysqli_insert_id($conn);

    http_response_code(200);
    $response['id_viagem'] = $idViagem;

} else {
    http_response_code(405);
    $response['message'] = 'Não foi possível iniciar a viagem.';
}

echo json_encode($response);