<?php

include ('../inc/conexao.php');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idLogin = $_POST['id_login'];
    $idViagem = $_POST['id_viagem'];
    $kmFinal = $_POST['kmFinal'];

    date_default_timezone_set('America/Sao_Paulo');
    $datahorafinal = date('Y-m-d H:i:s');

    $status_viagem = 0;

    if (!isset($kmFinal)) {
        http_response_code(500);
        $response['message'] = "Quilometragem final nula";
        echo json_encode($response);
        return;
    }

    $verificaKmInicial = "SELECT km_inicial FROM tb_viagem WHERE id_viagem = ?";
    $stmt = $conn->prepare($verificaKmInicial);
    $stmt->bind_param("i", $idViagem);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $kmInicial = $row['km_inicial'];

        if ($kmFinal < $kmInicial) {
            http_response_code(500);
            $response['message'] = "O km final não pode ser menor que o inicial.";
            echo json_encode($response);
            return;
        } else {

            $insereKmFinal = "UPDATE tb_viagem SET km_final = ?, datahora_final = ? WHERE id_viagem = ?";
            $stmt2 = $conn->prepare($insereKmFinal);
            $stmt2->bind_param("isi", $kmFinal, $datahorafinal, $idViagem);
            $stmt2->execute();

            if ($stmt2->affected_rows < 1) {
                http_response_code(500);
                $response['message'] = "Não foi possível finalizar a viagem.";
                echo json_encode($response);
                return;
            } else {
                http_response_code(200);
                $response['message'] = "Viagem finalizada com sucesso";
                echo json_encode($response);
                return;
            }

            $atualizaStatusViagem = "UPDATE tb_login SET status_viagem = ? WHERE id_login = ?";
            $stmt3 = $conn->prepare($atualizaStatusViagem);
            $stmt3->bind_param("ii", 0, $idLogin);
            $stmt3->execute();



        }
    } else {
        http_response_code(500);
        $response['message'] = "Não foi possível verificar a quilometragem inicial, tente novamente.";
        echo json_encode($response);
        return;
    }
}