<?php
include('../../inc/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $secretaria = $_POST['secretaria'];

    // Use uma consulta preparada para evitar SQL Injection
    $sql = "SELECT nome_setor FROM tb_setor WHERE id_secretaria = ?";

    // Prepare a consulta
    $stmt = $conn->prepare($sql);

    // Vincule o parâmetro
    $stmt->bind_param("i", $secretaria);

    // Execute a consulta
    $stmt->execute();

    // Obtenha o resultado
    $result = $stmt->get_result();

    // Inicialize um array para armazenar os nomes dos setores
    $opcoes = array();

    // Itere sobre os resultados e adicione os nomes dos setores ao array
    while ($row = $result->fetch_assoc()) {
        $opcoes[] = $row['nome_setor'];
    }

    // Codifique o array de opções como JSON e envie de volta como resposta
    echo json_encode($opcoes);
}
