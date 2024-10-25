<?php
include ('../../../inc/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = $_POST['matricula'];
    $disponivel = 1;

    $searchIdLogin = "SELECT id_login FROM tb_login WHERE matricula = ?";
    $search_stmt = $conn->prepare($searchIdLogin);
    $search_stmt->bind_param("i", $matricula);
    $search_stmt->execute();
    $result = $search_stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $idLogin = $row['id_login'];

        $sql = "SELECT lc.id_veiculo, c.placa, c.modelo FROM tb_login_veiculo lc 
            INNER JOIN tb_veiculo c ON c.id_veiculo = lc.id_veiculo
            WHERE lc.id_login = ?
            AND lc.disponivel = ?
            ORDER BY c.placa ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $idLogin, $disponivel);
        $stmt->execute();
        $result = $stmt->get_result();

        $opcoes = array();

        while ($row = $result->fetch_assoc()) {
            $opcoes[] = array(
                'id_veiculo' => $row['id_veiculo'],
                'placa' => $row['placa'],
                'modelo' => $row['modelo']
            );
        }

    } else {
        echo json_encode(array("status" => "error", "message" => "Não foi possível desvincular o veiculo ao seu usuário, tente novamente. (Matrícula não encontrada)"));
    }

    echo json_encode($opcoes);
}