<?php
include('../../inc/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $sql = "SELECT nome_secretaria FROM tb_secretaria";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(array("status" => "error", "message" => "Erro ao preparar a consulta."));
        exit;
    }

    $stmt->execute();

    $result = $stmt->get_result();
    if (!$result) {
        echo json_encode(array("status" => "error", "message" => "Erro ao executar a consulta."));
        exit;
    }

    $opcoesSecretaria = array();

    while ($row = $result->fetch_assoc()) {
        $opcoesSecretaria[] = $row['nome_secretaria'];
    }

    if (count($opcoesSecretaria) > 0) {
        echo json_encode($opcoesSecretaria);
    } else {
        echo json_encode(array("status" => "error", "message" => "Nenhum setor encontrado."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Método inválido para acessar esta página."));
}