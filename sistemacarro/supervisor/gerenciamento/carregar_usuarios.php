<?php
include('../../inc/conexao.php');

session_start();

$id_secretaria = $_SESSION['secretaria'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPerfil = 3;
    $ativo = 1;

    $sql = "SELECT l.nome, s.nome_setor AS setor, l.matricula, l.id_login
            FROM tb_login l
            INNER JOIN tb_setor s ON l.setor = s.id_setor
            WHERE l.id_perfil = ? AND l.ativo = ? AND l.secretaria = ?
            ORDER BY l.nome ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $idPerfil, $ativo, $id_secretaria);
    $stmt->execute();
    $result = $stmt->get_result();

    $usuarios = array();
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }

    echo json_encode($usuarios);
}