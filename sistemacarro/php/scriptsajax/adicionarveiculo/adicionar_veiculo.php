<?php 

include ('../../../inc/conexao.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idLogin = $_SESSION['id_login'];
    $id_secretaria = $_SESSION['secretaria'];
    $placa = mysqli_real_escape_string($conn, $_POST['placa']);
    $modelo = mysqli_real_escape_string($conn, $_POST['modelo']);
    $disponivel = 1;

    $adicionarVeiculo = "INSERT INTO tb_veiculo (placa, modelo, secretaria, id_login, disponivel) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($adicionarVeiculo);
    $stmt->bind_param("ssiii", $placa, $modelo, $id_secretaria, $idLogin, $disponivel);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(array("status" => "success", "message" => "Veiculo adicionado com sucesso."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Não foi possível adicionar o veiculo ao seu usuário, tente novamente."));
    }
}