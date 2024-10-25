<?php
include ('../../inc/conexao.php');

session_start();

$id_secretaria = $_SESSION['secretaria'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $resolvido = 1;
    $tipo = 3;

    $sql = "SELECT l.nome, l.matricula, se.nome_setor, s.id_solicitacao, s.texto, v.placa, v.modelo, s.data_solicitacao FROM tb_solicitacoes s
            INNER JOIN tb_veiculo v ON v.id_veiculo = s.texto
            INNER JOIN tb_login l ON l.id_login = s.solicitador
            INNER JOIN tb_setor se ON se.id_setor = l.setor
            WHERE s.resolvido = ?
            AND s.tipo = ?
            AND l.secretaria = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $resolvido, $tipo, $id_secretaria);
    $stmt->execute();
    $result = $stmt->get_result();

    $solicitacoes = array();
    while ($row = $result->fetch_assoc()) {

        $row['veiculo'] = $row['placa'] . " / " . $row['modelo'];

        $solicitacoes[] = $row;

    }

    echo json_encode($solicitacoes);
}