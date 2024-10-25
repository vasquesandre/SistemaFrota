<?php

include ('../inc/conexao.php');

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the JSON data from the request body
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    if ($data === null) {
        $response['status'] = "error";
        $response['message'] = "Invalid JSON data.";
        http_response_code(400);
        echo json_encode($response);
        exit;
    }

    $idViagem = $data["id_viagem"];
    $idLogin = $data["id_login"];
    $locations = $data["locations"];

    $coordinates = array_map(function($location) {
        return $location['latitude'] . ',' . $location['longitude'];
    }, $locations);

    $ultimoElemento = end($coordinates);

    foreach ($coordinates as $coordinate) {
        $insereCoordenadas = "INSERT INTO tb_coordenadas (id_viagem, coordenadas) VALUES ('$idViagem', '$coordinate')";
        $resultCoordenadas = mysqli_query($conn, $insereCoordenadas);
        if (!$resultCoordenadas) {
            $response['status'] = "error";
            $response['message'] = "Erro ao inserir coordenadas na viagem.";
            http_response_code(500);
            echo json_encode($response);
            exit;
        }
    }

    $atualizarMotorista = "UPDATE tb_login SET coordenadas = '$ultimoElemento' WHERE id_login = '$idLogin'";
    $resultAtualizarMotorista = mysqli_query($conn, $atualizarMotorista);
    if (!$resultAtualizarMotorista) {
        $response['status'] = "error";
        $response['message'] = "Erro ao inserir coordenadas do motorista.";
        http_response_code(500);
        echo json_encode($response);
        exit;
    }

    $response['status'] = "success";
    $response['message'] = "Coordenadas inseridas na viagem.";
    http_response_code(200);
    echo json_encode($response);
} else {
    $response['status'] = "error";
    $response['message'] = 'Não foi possível atualizar a localização.';
    http_response_code(405);
    echo json_encode($response);
}
?>
