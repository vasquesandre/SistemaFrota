<?php

include ('../../../inc/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $placa = $_POST['placa'];
    $novaSecretaria = $_POST['novaSecretaria'];

    $search_id_veiculo = "SELECT id_veiculo FROM tb_veiculo WHERE placa = ?";
    $stmt = $conn->prepare($search_id_veiculo);
    $stmt->bind_param("s", $placa);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_veiculo = $row['id_veiculo'];

        $sql = "UPDATE tb_veiculo SET secretaria = ? WHERE id_veiculo = ?";
        $stmt2 = $conn->prepare($sql);
        $stmt2->bind_param("ii", $novaSecretaria, $id_veiculo);
        $stmt2->execute();

        if ($stmt2->affected_rows > 0) {
            echo json_encode(array("status" => "success", "message" => "Secretaria atualizada com sucesso."));
        } else {
            echo json_encode(array("status" => "error", "message" => "Ocorreu um erro ao atualizar a secretaria do veículo, tente novamente."));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Não foi encontrado nenhum veículo com esta placa, tente novamente."));
    }
}