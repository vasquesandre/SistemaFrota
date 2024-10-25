<?php
include('../../inc/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeSetor = isset($_POST['setor']) ? mysqli_real_escape_string($conn, $_POST['setor']) : '';
    $novoNomeSetor = isset($_POST['novoNome']) ? mysqli_real_escape_string($conn, $_POST['novoNome']) : '';
    $secretaria = isset($_POST['secretaria']) ? mysqli_real_escape_string($conn, $_POST['secretaria']) : '';
    if (empty($nomeSetor) || empty($novoNomeSetor) || empty($secretaria)) {
        echo json_encode(array("status" => "error", "message" => "Parâmetros incompletos."));
        exit;
    }
    
    $consultaIdSetor = "SELECT id_setor FROM tb_setor WHERE nome_setor = ?";
    $stmt = $conn->prepare($consultaIdSetor);
    $stmt->bind_param('s', $nomeSetor);
    $stmt->execute();
    $resultIdSetor = $stmt->get_result();

    if ($resultIdSetor && $resultIdSetor->num_rows > 0) {
        $row = $resultIdSetor->fetch_assoc();
        $idSetor = $row['id_setor'];

        $consultaExistencia = "SELECT COUNT(*) AS total FROM tb_setor WHERE nome_setor = ? AND id_secretaria = ?";
        $stmt2 = $conn->prepare($consultaExistencia);
        $stmt2->bind_param('ss', $novoNomeSetor, $secretaria);
        $stmt2->execute();
        $resultExistencia = $stmt2->get_result();
        $rowExistencia = $resultExistencia->fetch_assoc();
        $total = $rowExistencia['total'];

        if ($total === 0) {
            $atualizarSetor = "UPDATE tb_setor SET nome_setor = ? WHERE id_setor = ?";
            $stmt3 = $conn->prepare($atualizarSetor);
            $stmt3->bind_param('si', $novoNomeSetor, $idSetor);
            $stmt3->execute();

            echo json_encode(array("status" => "success", "message" => "Setor renomeado com sucesso."));
        } else {
            echo json_encode(array("status" => "error", "message" => "Não foi possível renomear pois já existe outro setor com este nome."));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Setor não encontrado, tente novamente."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Método inválido para acessar esta página."));
}