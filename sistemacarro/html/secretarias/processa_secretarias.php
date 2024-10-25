<?php
include ('../../inc/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    if (isset($_POST['nome_secretaria']) && !empty($_POST['nome_secretaria'])) {
        $nome_secretaria = $_POST['nome_secretaria'];

        $verificaExistencia = "SELECT nome_secretaria FROM tb_secretaria WHERE nome_secretaria = '$nome_secretaria'";
        $resultExistencia = mysqli_query($conn, $verificaExistencia);

        if (mysqli_num_rows($resultExistencia) > 0) {
            echo json_encode(array("status" => "error", "message" => "A secretaria já existe."));
            exit;
        } else {
            $adicionarSecretaria = "INSERT INTO tb_secretaria (nome_secretaria) VALUES ('$nome_secretaria')";
            
            if (mysqli_query($conn, $adicionarSecretaria)) {
                echo json_encode(array("status" => "success", "message" => "Secretaria adicionada com sucesso."));
            } else {
                echo json_encode(array("status" => "error", "message" => "Erro ao adicionar secretaria."));
            }
        }
    } else {
        echo json_encode(array("status" => "warning", "message" => "Digite o nome da secretaria."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Método inválido para acessar esta página."));
}