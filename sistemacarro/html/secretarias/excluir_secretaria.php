<?php

include ('../../inc/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeSecretaria = $_POST['secretaria'];

    $consultaIdSecretaria = "SELECT id_secretaria FROM tb_secretaria WHERE nome_secretaria = ?";
    $stmt = $conn->prepare($consultaIdSecretaria);
    $stmt->bind_param('s', $nomeSecretaria);
    $stmt->execute();
    $resultIdSecretaria = $stmt->get_result();

    if ($resultIdSecretaria) {
        $row = $resultIdSecretaria->fetch_assoc();
        $idSecretaria = $row['id_secretaria'];

        //verificar se alguem está filiado a este Secretaria
        $consultaFiliado = "SELECT COUNT(*) AS total FROM tb_login WHERE secretaria = ?";
        $stmt2 = $conn->prepare($consultaFiliado);
        $stmt2->bind_param('s', $idSecretaria);
        $stmt2->execute();
        $resultFiliado = $stmt2->get_result();
        $rowFiliado = $resultFiliado->fetch_assoc();
        $total = $rowFiliado['total'];

        if ($total === 0) {
            $excluirSecretaria =  "DELETE FROM tb_secretaria WHERE id_secretaria = ?";
            $stmt3 = $conn->prepare($excluirSecretaria);
            $stmt3->bind_param('s', $idSecretaria);
            $stmt3->execute();

            echo json_encode(array("status" => "success", "message" => "Secretaria excluída com sucesso."));
        } else {
            echo json_encode(array("status" => "error", "message" => "Não foi possível excluir esta secretaria pois existem pessoas filiadas a ela."));
        }

    } else {
        echo json_encode(array("status" => "error", "message" => "Secretaria não encontrada, tente novamente."));
    }
}