<?php
include('../../inc/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $placa = $_POST['placa'];

    $sql = "SELECT l.nome, l.matricula, CONCAT(SUBSTRING_INDEX(s.nome_secretaria, '-', 1), ' / ', se.nome_setor) AS secretaria_setor, ve.id_veiculo AS token, ve.placa, ve.modelo FROM tb_login_veiculo v
            INNER JOIN tb_login l ON l.id_login = v.id_login
            INNER JOIN tb_secretaria s ON s.id_secretaria = l.secretaria
            INNER JOIN tb_setor se ON se.id_setor = l.setor
            INNER JOIN tb_veiculo ve ON ve.id_veiculo = v.id_veiculo
            WHERE ve.placa = ? AND v.disponivel = 1
            ORDER BY l.nome ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $placa);
    $stmt->execute();
    $result = $stmt->get_result();

    $veiculos = array();
    while ($row = $result->fetch_assoc()) {
        $veiculos[] = $row;
    }

    echo json_encode($veiculos);
}