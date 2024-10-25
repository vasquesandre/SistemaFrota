<?php
include('../../inc/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    if (isset($_POST['nome_setor']) && !empty($_POST['secretaria'])) {
        $nome_setor = mysqli_real_escape_string($conn, $_POST['nome_setor']);
        $id_secretaria = mysqli_real_escape_string($conn, $_POST['secretaria']);

        // Consulta preparada para prevenir injeção de SQL
        $verificaExistencia = "SELECT nome_setor FROM tb_setor WHERE nome_setor = ? AND id_secretaria = ?";
        $stmt = mysqli_prepare($conn, $verificaExistencia);
        mysqli_stmt_bind_param($stmt, "si", $nome_setor, $id_secretaria);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo json_encode(array("status" => "error", "message" => "O setor já existe."));
            exit;
        } else {
            $adicionarSetor = "INSERT INTO tb_setor (id_secretaria, nome_setor) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $adicionarSetor);
            mysqli_stmt_bind_param($stmt, "is", $id_secretaria, $nome_setor);

            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(array("status" => "success", "message" => "Setor adicionado com sucesso."));
            } else {
                echo json_encode(array("status" => "error", "message" => "Erro ao adicionar setor."));
            }
        }
    } else {
        echo json_encode(array("status" => "warning", "message" => "Digite o nome do setor."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Método inválido para acessar esta página."));
}