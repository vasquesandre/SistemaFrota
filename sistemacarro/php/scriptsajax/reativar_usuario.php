<?php

include('../../inc/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idLogin = $_POST['id_login'];
    $ativo = 1;
    $idPerfil = 3;
    
    $atualizarAtivo = "UPDATE tb_login SET ativo = ?, id_perfil = ? WHERE id_login = ?";
    $stmt = $conn->prepare($atualizarAtivo);
    $stmt->bind_param("iii", $ativo, $idPerfil, $idLogin);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(array("status" => "success", "message" => "Usuário reativado com sucesso."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Não foi possível raativar este usuário, tente novamente."));
    }
}