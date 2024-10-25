<?php

include ('../../../inc/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = $_POST['usuario'];
    $idVeiculo = $_POST['index'];
    $disponivel = 0;

    $searchIdLogin = "SELECT id_login FROM tb_login WHERE matricula = ?";
    $search_stmt = $conn->prepare($searchIdLogin);
    $search_stmt->bind_param("i", $matricula);
    $search_stmt->execute();
    $result = $search_stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $idLogin = $row['id_login'];

        $sql = "UPDATE tb_login_veiculo SET disponivel = ? WHERE id_login = ? AND id_veiculo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $disponivel, $idLogin, $idVeiculo);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(array("status" => "success", "message" => "Veiculo desvinculado com sucesso."));
        } else {
            echo json_encode(array("status" => "error", "message" => "Não foi possível desvincular o veiculo ao seu usuário, tente novamente."));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Não foi possível desvincular o veiculo ao seu usuário, tente novamente. (Matrícula não encontrada)"));
    }
}