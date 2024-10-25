<?php
include('../../inc/conexao.php');

session_start();

$idLogin = $_SESSION['id_login'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $disponivel = 1;

    $sql = "SELECT l.matricula, lc.id_veiculo, c.placa, c.modelo FROM tb_login_veiculo lc 
            INNER JOIN tb_login l ON l.id_login = lc.id_login
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
            'modelo' => $row['modelo'],
            'matricula' => $row['matricula']
        );
    }

    echo json_encode($opcoes);
}