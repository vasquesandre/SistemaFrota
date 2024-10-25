<?php

include ('../../../inc/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['index'])) {
    $placa = $_POST['index'];

    $searchIdVeiculo = "SELECT id_veiculo FROM tb_veiculo WHERE placa = ?";
    $search_id_stmt = $conn->prepare($searchIdVeiculo);
    $search_id_stmt->bind_param('s', $placa);
    $search_id_stmt->execute();
    $search_id_result = $search_id_stmt->get_result();

    if ($search_id_result->num_rows > 0) {
        $row_id = $search_id_result->fetch_assoc();
        $id_veiculo = $row_id['id_veiculo'];

        $sql = "UPDATE tb_veiculo SET disponivel = 0 WHERE id_veiculo = ?";
        $stmt_veiculo = $conn->prepare($sql);
        $stmt_veiculo->bind_param("i", $id_veiculo);
        $stmt_veiculo->execute();

        if ($stmt_veiculo->affected_rows > 0) {
            $sql_search = "SELECT id_veiculo FROM tb_login_veiculo WHERE id_veiculo = ?";
            $stmt_search = $conn->prepare($sql_search);
            $stmt_search->bind_param("i", $id_veiculo);
            $stmt_search->execute();
            $result_search = $stmt_search->get_result();

            if ($result_search->num_rows > 0) {
                $sql_login_veiculo = "UPDATE tb_login_veiculo SET disponivel = 0 WHERE id_veiculo = ?";
                $stmt_login_veiculo = $conn->prepare($sql_login_veiculo);
                $stmt_login_veiculo->bind_param("i", $id_veiculo);
                $stmt_login_veiculo->execute();

                if ($stmt_login_veiculo->affected_rows > 0) {
                    echo json_encode(array("status" => "success", "message" => "Veículo desativado com sucesso."));
                } else {
                    echo json_encode(array("status" => "error", "message" => "Não foi possível desativar o veículo, tente novamente."));
                }
            } else {
                echo json_encode(array("status" => "success", "message" => "Veículo desativado com sucesso."));
            }

        } else {
            echo json_encode(array("status" => "error", "message" => "Não foi possível desativar o veículo, tente novamente."));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Placa de veículo não encontrada."));
    }
}
