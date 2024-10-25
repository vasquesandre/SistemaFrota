<?php

include ('../../../inc/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = $_POST['matricula'];

    $sql = "SELECT nome FROM tb_login WHERE matricula = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $matricula);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $nome = array();
    
        while ($row = $result->fetch_assoc()) {
            $nome[] = $row;
        }
    
        echo json_encode(array("status" => "success", "message" => $nome));
    } else {
        echo json_encode(array("status" => "error", "message" => "Nenhum registro encontrado"));
    }
}