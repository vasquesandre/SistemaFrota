<?php

include ('../../inc/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula =  mysqli_real_escape_string($conn, $_POST["matricula"]);

    $sql = "SELECT l.id_login, l.nome, l.usuario, l.email, l.matricula, l.ativo, s.nome_secretaria, se.nome_setor, p.nome_perfil FROM tb_login l
            INNER JOIN tb_perfil p ON p.id_perfil = l.id_perfil
            INNER JOIN tb_secretaria s ON s.id_secretaria = l.secretaria
            INNER JOIN tb_setor se ON se.id_setor = l.setor
            WHERE l.matricula = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $matricula);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $dados = array();
        
        while ($linha = $result->fetch_assoc()) {
            $dados[] = $linha;
        }

        echo json_encode(array("status" => "success", "message" => $dados));
    } else {
        echo json_encode(array("status" => "error", "message" => "Matrícula não encontrada."));
    }
}