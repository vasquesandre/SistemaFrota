<?php

include ('../../../inc/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $placaVeiculo = $_POST['placaVeiculo'];

    $sql = "SELECT id_veiculo, placa, modelo FROM tb_veiculo WHERE placa = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $placaVeiculo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $veiculo = array();
    
        while ($row = $result->fetch_assoc()) {
            $veiculo[] = $row;
        }
    
        echo json_encode(array("status" => "success", "message" => $veiculo));
    } else {
        echo json_encode(array("status" => "error", "message" => "Nenhum registro encontrado"));
    }
}