<?php

include ('../../inc/conexao.php');

if (!isset($_SESSION)) {
    session_start();
}

$nome = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$usuario = isset($_SESSION['user']) ? $_SESSION['user'] : '';
$email = isset($_SESSION['mail']) ? $_SESSION['mail'] : (isset($_POST['email']) ? $_POST['email'] : '');
$matricula = isset($_SESSION['office']) ? $_SESSION['office'] : (isset($_POST['matricula']) ? $_POST['matricula'] : '');
$secretaria = $_POST['secretaria'];
$setor = $_POST['setor'];

$sql = "INSERT INTO tb_login (usuario, nome, email, matricula, secretaria, setor, id_perfil, coordenadas, status_viagem, ativo)
        VALUES (?, ?, ?, ?, ?, ?, 3, 'Sem coordenadas', 0, 1)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $usuario, $nome, $email, $matricula, $secretaria, $setor);

if ($stmt->execute()) {
    $mensagem = "Cadastro Feito com Sucesso!";
    header("Location: logout.php");
    $stmt->close();
    $conn->close();
    exit;
} else {
    $mensagem = "Erro ao Inserir Dados.";
    header("Location: cadastro_usuario.php?erro=" . urlencode($mensagem));
    $stmt->close();
    $conn->close();
    exit;
}