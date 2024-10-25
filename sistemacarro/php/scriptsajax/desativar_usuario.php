<?php

include('../../inc/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idLogin = $_POST['id_login'];
    $ativo = 0;
    $idPerfil = 3;
    
    $atualizarAtivo = "UPDATE tb_login SET ativo = ?, id_perfil = ? WHERE id_login = ?";
    $stmt = $conn->prepare($atualizarAtivo);
    $stmt->bind_param("iii", $ativo,$idPerfil, $idLogin);
    $stmt->execute();

    // Verifique se a consulta foi executada com sucesso
    if ($stmt->affected_rows > 0) {
        echo json_encode(array("status" => "success", "message" => "Usuário desativado com sucesso."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Não foi possível desativar este usuário, tente novamente."));
    }
}