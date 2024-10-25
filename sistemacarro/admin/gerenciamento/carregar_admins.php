<?php
include('../../inc/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPerfil = 1;
    $ativo = 1;

    $sql = "SELECT l.nome, sc.nome_secretaria AS secretaria, s.nome_setor AS setor, l.matricula, l.id_login
            FROM tb_login l
            INNER JOIN tb_secretaria sc ON sc.id_secretaria = l.secretaria
            INNER JOIN tb_setor s ON l.setor = s.id_setor
            WHERE l.id_perfil = ? AND ativo = ?
            ORDER BY l.nome ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idPerfil, $ativo);
    $stmt->execute();
    $result = $stmt->get_result();

    $usuarios = array();
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }

    echo json_encode($usuarios);
}