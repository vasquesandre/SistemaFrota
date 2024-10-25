<?php

include('../../../inc/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idLogin = $_POST['id_login'];
    
    $atualizarSetor = "UPDATE tb_login SET id_perfil = id_perfil + 1 WHERE id_login = ?";
    $stmt = $conn->prepare($atualizarSetor);
    $stmt->bind_param("i", $idLogin);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $consultaPerfil = "SELECT id_perfil FROM tb_login WHERE id_login = ?";
        $stmtConsulta = $conn->prepare($consultaPerfil);
        $stmtConsulta->bind_param("i", $idLogin);
        $stmtConsulta->execute();
        $resultado = $stmtConsulta->get_result();
        $linha = $resultado->fetch_assoc();
        $novoIdPerfil = $linha['id_perfil'];

        if ($novoIdPerfil == 2) {
            $message = "Rebaixado para supervisor.";
        } else if ($novoIdPerfil == 3) {
            $message = "Rebaixado para usuário padrão.";
        }
        
        echo json_encode(array("status" => "success", "message" => $message));
    } else {
        echo json_encode(array("status" => "error", "message" => "Não foi possível rebaixar o nível, tente novamente."));
    }
}