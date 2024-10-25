<?php

include ('../../../inc/conexao.php');

session_start();

$id_login = $_SESSION['id_login'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_solicitacao = mysqli_real_escape_string($conn, $_POST['index']);
    $resolvido = 1;

    date_default_timezone_set('America/Sao_Paulo');
    $datahora = date('Y-m-d H:i:s');

    $sql = "UPDATE tb_solicitacoes SET resolvido = ?, data_resolvido = ?, resolvidopor = ? WHERE id_solicitacao = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isii", $resolvido, $datahora, $id_login, $id_solicitacao);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(array("status" => "success", "message" => "Solicitação resolvida."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Não foi possível marcar esta solicitação como resolvida, tente novamente."));
    }
}