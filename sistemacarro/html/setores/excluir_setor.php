<?php

include ('../../inc/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeSetor = $_POST['setor'];

    $consultaIdSetor = "SELECT id_setor FROM tb_setor WHERE nome_setor = ?";
    $stmt = $conn->prepare($consultaIdSetor);
    $stmt->bind_param('s', $nomeSetor);
    $stmt->execute();
    $resultIdSetor = $stmt->get_result();

    if ($resultIdSetor) {
        $row = $resultIdSetor->fetch_assoc();
        $idSetor = $row['id_setor'];

        //verificar se alguem está filiado a este setor
        $consultaFiliado = "SELECT COUNT(*) AS total FROM tb_login WHERE setor = ?";
        $stmt2 = $conn->prepare($consultaFiliado);
        $stmt2->bind_param('s', $idSetor);
        $stmt2->execute();
        $resultFiliado = $stmt2->get_result();
        $rowFiliado = $resultFiliado->fetch_assoc();
        $total = $rowFiliado['total'];

        if ($total === 0) {
            $excluirSetor =  "DELETE FROM tb_setor WHERE id_setor = ?";
            $stmt3 = $conn->prepare($excluirSetor);
            $stmt3->bind_param('s', $idSetor);
            $stmt3->execute();

            echo json_encode(array("status" => "success", "message" => "Setor excluído com sucesso."));
        } else {
            echo json_encode(array("status" => "error", "message" => "Não foi possível excluir este setor pois existem pessoas filiadas a ele."));
        }

    } else {
        echo json_encode(array("status" => "error", "message" => "Setor não encontrado, tente novamente."));
    }
}