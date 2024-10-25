<?php

include ('../../inc/conexao.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $placa = $_POST['placa'];
    $setor = $_SESSION['setor'];
    $solicitador = $_SESSION['id_login'];

    date_default_timezone_set('America/Sao_Paulo');
    $datahora = date('Y-m-d H:i:s');

    $tipo = 3;
    $resolvido = 0;

    $nomeSetor = "SELECT s.nome_setor, se.nome_secretaria FROM tb_setor s
                    INNER JOIN tb_secretaria se ON se.id_secretaria = s.id_secretaria
                    WHERE id_setor = ?";
    $stmt = $conn->prepare($nomeSetor);
    $stmt->bind_param('i', $setor);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $setor = $row['nome_setor'];
        $secretaria = $row['nome_secretaria'];

        $getid_veiculo = "SELECT id_veiculo FROM tb_veiculo WHERE placa = ?";
        $stmt2 = $conn->prepare($getid_veiculo);
        $stmt2->bind_param('s', $placa);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        if ($result2->num_rows > 0) {
            $row2 = $result2->fetch_assoc();
            $id_veiculo = $row2['id_veiculo'];

            $disponivel = 1;

            $search_vinculo = "SELECT id_login, id_veiculo, disponivel FROM tb_login_veiculo
                        WHERE id_login = ?
                        AND id_veiculo = ?
                        AND disponivel = ?";
            $vinculo_stmt = $conn->prepare($search_vinculo);
            $vinculo_stmt->bind_param("iii", $solicitador, $id_veiculo, $disponivel);
            $vinculo_stmt->execute();
            $vinculo_result = $vinculo_stmt->get_result();

            if ($vinculo_result->num_rows > 0) {
                echo json_encode(array("status" => "warning", "message" => "Você já possui um vínculo com este veículo."));
            } else {
                $search_sql = "SELECT tipo, solicitador, texto, resolvido FROM tb_solicitacoes
                    WHERE tipo = ?
                    AND solicitador = ?
                    AND texto = ?
                    AND resolvido = ?";
                $stmt3 = $conn->prepare($search_sql);
                $stmt3->bind_param("iiii", $tipo, $solicitador, $id_veiculo, $resolvido);
                $stmt3->execute();
                $result3 = $stmt3->get_result();

                if ($result3->num_rows == 0) {
                    $sql = "INSERT INTO tb_solicitacoes (tipo, solicitador, texto, resolvido, data_solicitacao) VALUES (?, ?, ?, ?, ?)";
                    $stmt4 = $conn->prepare($sql);
                    $stmt4->bind_param("iiiis", $tipo, $solicitador, $id_veiculo, $resolvido, $datahora);
                    $stmt4->execute();

                    if ($stmt4->affected_rows > 0) {
                        echo json_encode(array("status" => "success", "message" => "Solicitação enviada com sucesso."));
                    } else {
                        echo json_encode(array("status" => "error", "message" => "Não foi possível enviar a solicitação, tente novamente. (100)"));
                    }
                } else {
                    echo json_encode(array("status" => "warning", "message" => "Você já possui uma solicitação para vincular este veículo."));
                }
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Não foi possível enviar a solicitação, tente novamente. (105)"));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Não foi possível enviar a solicitação, tente novamente. (110)"));
    }
}
