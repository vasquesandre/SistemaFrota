<?php

include ('../../inc/conexao.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = mysqli_real_escape_string($conn, $_POST['matricula']);
    $secretaria = mysqli_real_escape_string($conn, $_POST['secretaria']);
    $setor = mysqli_real_escape_string($conn, $_POST['setor']);
    $solicitador = $_SESSION['id_login'];

    date_default_timezone_set('America/Sao_Paulo');
    $datahora = date('Y-m-d H:i:s');

    $tipo = 1;
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
    }

    $texto = $matricula . " / " . $secretaria . " | " . $setor;

    $sql = "INSERT INTO tb_solicitacoes (tipo, solicitador, texto, resolvido, data_solicitacao) VALUES (?, ?, ?, ?, ?)";
    $stmt2 = $conn->prepare($sql);
    $stmt2->bind_param("iisis", $tipo, $solicitador, $texto, $resolvido, $datahora);
    $stmt2->execute();

    if ($stmt2->affected_rows > 0) {
        echo json_encode(array("status" => "success", "message" => "Solicitação enviada com sucesso."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Não foi possível enviar a solicitação, tente novamente."));
    }
}
