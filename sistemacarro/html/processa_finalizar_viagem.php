<?php

include ('../inc/conexao.php');

session_start();

$idLogin = $_SESSION['id_login'];
$idViagem = $_SESSION['id_viagem'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kmFinal = $_POST['kmFinal'];

    $verificaKmInicial = "SELECT km_inicial FROM tb_viagem WHERE id_viagem = ?";
    $stmt = $conn->prepare($verificaKmInicial);
    $stmt->bind_param("i", $idViagem);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $kmInicial = $row['km_inicial'];

        if ($kmFinal < $kmInicial) {
            echo json_encode(array("status" => "error", "message" => "O KM final não pode ser menor que o KM inicial."));
        } else {

            $insereKmFinal = "UPDATE tb_viagem SET km_final = ? WHERE id_viagem = ?";
            $stmt2 = $conn->prepare($insereKmFinal);
            $stmt2->bind_param("ii", $kmFinal, $idViagem);
            $stmt2->execute();

            $statusViagem = 0;

            $atualizaStatusViagem = "UPDATE tb_login SET status_viagem = ? WHERE id_login = ?";
            $stmt3 = $conn->prepare($atualizaStatusViagem);
            $stmt3->bind_param("ii", $statusViagem, $idLogin);
            $stmt3->execute();

            if ($stmt2->affected_rows > 0 && $stmt3->affected_rows > 0) {
                echo json_encode(array("status" => "success", "message" => "Viagem finalizada com sucesso."));
            } else {
                echo json_encode(array("status" => "error", "message" => "Erro ao finalizar a viagem."));
            }
        }
    }
}