<?php 

include ('../../inc/conexao.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idLogin = $_SESSION['id_login'];
    $idVeiculo = $_POST['index'];
    $disponivel = 0;

    $sql = "UPDATE tb_login_veiculo SET disponivel = ? WHERE id_login = ? AND id_veiculo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $disponivel, $idLogin, $idVeiculo);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(array("status" => "success", "message" => "Veiculo desvinculado com sucesso."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Não foi possível desvincular o veiculo ao seu usuário, tente novamente."));
    }
}