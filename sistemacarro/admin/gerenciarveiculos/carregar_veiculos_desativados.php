<?php
include('../../inc/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sql = "SELECT l.nome, l.matricula, CONCAT(SUBSTRING_INDEX(s.nome_secretaria, '-', 1), ' / ', se.nome_setor) AS secretaria_setor, v.placa, v.modelo FROM tb_veiculo v
            INNER JOIN tb_login l ON l.id_login = v.id_login
            INNER JOIN tb_secretaria s ON s.id_secretaria = l.secretaria
            INNER JOIN tb_setor se ON se.id_setor = l.setor
            WHERE v.disponivel = 0
            ORDER BY v.placa ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $veiculos = array();
    while ($row = $result->fetch_assoc()) {
        $veiculos[] = $row;
    }

    echo json_encode($veiculos);
}