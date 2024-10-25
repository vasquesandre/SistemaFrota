<?php
include('../../inc/conexao.php');

session_start();

$idSecretaria = $_SESSION['secretaria'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sql = "SELECT l.nome, l.matricula, se.nome_setor, v.placa, v.modelo FROM tb_veiculo v
            INNER JOIN tb_login l ON l.id_login = v.id_login
            INNER JOIN tb_setor se ON se.id_setor = l.setor
            WHERE v.disponivel = 1
            AND v.secretaria = '$idSecretaria'
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