<?php

include ('../../../inc/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = mysqli_real_escape_string($conn, $_POST['matricula']);
    $placa = mysqli_real_escape_string($conn, $_POST['index']);

    $disponivel = 1;

    $sql = "SELECT id_login FROM tb_login WHERE matricula = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $matricula);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_login = $row['id_login'];

        if (strpos($placa, '-') !== false) {
            $searchIdVeiculo = "SELECT id_veiculo FROM tb_veiculo WHERE placa = ?";
            $search_id_stmt = $conn->prepare($searchIdVeiculo);
            $search_id_stmt->bind_param('s', $placa);
            $search_id_stmt->execute();
            $search_id_result = $search_id_stmt->get_result();

            if ($search_id_result->num_rows > 0) {
                $row_id = $search_id_result->fetch_assoc();
                $id_veiculo = $row_id['id_veiculo'];

                $search_sql = "SELECT id_login, id_veiculo, disponivel FROM tb_login_veiculo WHERE id_login = ? AND id_veiculo = ?";
                $search_stmt = $conn->prepare($search_sql);
                $search_stmt->bind_param("ii", $id_login, $id_veiculo);
                $search_stmt->execute();
                $search_result = $search_stmt->get_result();

                if ($search_result->num_rows > 0) {
                    $row2 = $search_result->fetch_assoc();

                    $search_disponivel = $row2['disponivel'];

                    if ($search_disponivel == 0) {
                        $update_sql = "UPDATE tb_login_veiculo SET disponivel = ? WHERE id_login = ? AND id_veiculo = ?";
                        $update_stmt = $conn->prepare($update_sql);
                        $update_stmt->bind_param("iii", $disponivel, $id_login, $id_veiculo);

                        if ($update_stmt->execute()) {
                            echo json_encode(array("status" => "success", "message" => "Este vínculo já existia mas estava desativado, portanto agora o vínculo foi reativado. Veículo vinculado."));
                        } else {
                            echo json_encode(array("status" => "error", "message" => "Não foi possível vincular o veículo ao usuário, tente novamente."));
                        }
                    } else {
                        echo json_encode(array("status" => "warning", "message" => "Este vínculo já existe."));
                    }
                } else {
                    $insert_sql = "INSERT INTO tb_login_veiculo (id_login, id_veiculo, disponivel) VALUES (?, ?, ?)";
                    $insert_stmt = $conn->prepare($insert_sql);
                    $insert_stmt->bind_param("iii", $id_login, $id_veiculo, $disponivel);

                    if ($insert_stmt->execute()) {
                        echo json_encode(array("status" => "success", "message" => "Veículo vinculado."));
                    } else {
                        echo json_encode(array("status" => "error", "message" => "Não foi possível vincular o veículo ao usuário, tente novamente."));
                    }
                }
            }
        } else {
            $id_veiculo = $placa;

            $search_sql = "SELECT id_login, id_veiculo, disponivel FROM tb_login_veiculo WHERE id_login = ? AND id_veiculo = ?";
            $search_stmt = $conn->prepare($search_sql);
            $search_stmt->bind_param("ii", $id_login, $placa);
            $search_stmt->execute();
            $search_result = $search_stmt->get_result();

            if ($search_result->num_rows > 0) {
                $row2 = $search_result->fetch_assoc();

                $search_disponivel = $row2['disponivel'];

                if ($search_disponivel == 0) {
                    $update_sql = "UPDATE tb_login_veiculo SET disponivel = ? WHERE id_login = ? AND id_veiculo = ?";
                    $update_stmt = $conn->prepare($update_sql);
                    $update_stmt->bind_param("iii", $disponivel, $id_login, $id_veiculo);

                    if ($update_stmt->execute()) {
                        echo json_encode(array("status" => "success", "message" => "Este vínculo já existia mas estava desativado, portanto agora o vínculo foi reativado. Veículo vinculado."));
                    } else {
                        echo json_encode(array("status" => "error", "message" => "Não foi possível vincular o veículo ao usuário, tente novamente."));
                    }
                } else {
                    echo json_encode(array("status" => "warning", "message" => "Este vínculo já existe."));
                }
            } else {
                $insert_sql = "INSERT INTO tb_login_veiculo (id_login, id_veiculo, disponivel) VALUES (?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("iii", $id_login, $id_veiculo, $disponivel);

                if ($insert_stmt->execute()) {
                    echo json_encode(array("status" => "success", "message" => "Veículo vinculado."));
                } else {
                    echo json_encode(array("status" => "error", "message" => "Não foi possível vincular o veículo ao usuário, tente novamente."));
                }
            }
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Matricula não encontrada."));
    }
}