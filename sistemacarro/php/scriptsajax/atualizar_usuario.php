<?php

include('../../inc/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idLogin = $_POST['id_login'];
    $secretaria = $_POST['novaSecretaria'];
    $setor = $_POST['novoSetor'];
    
    $atualizarSetor = "UPDATE tb_login SET secretaria = ?, setor = ? WHERE id_login = ?";
    $stmt = $conn->prepare($atualizarSetor);
    $stmt->bind_param("ssi", $secretaria, $setor, $idLogin);
    $stmt->execute();

    // Verifique se a consulta foi executada com sucesso
    if ($stmt->affected_rows > 0) {
        echo json_encode(array("status" => "success", "message" => "Setor atualizado com sucesso."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Não foi possível atualizar o setor, tente novamente."));
    }
}