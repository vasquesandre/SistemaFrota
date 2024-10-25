<?php
include('../../inc/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeSecretaria = isset($_POST['secretaria']) ? mysqli_real_escape_string($conn, $_POST['secretaria']) : '';
    $novoNomeSecretaria = isset($_POST['novoNome']) ? mysqli_real_escape_string($conn, $_POST['novoNome']) : '';
    if (empty($nomeSecretaria) || empty($novoNomeSecretaria)) {
        echo json_encode(array("status" => "error", "message" => "Parâmetros incompletos."));
        exit;
    }
    
    $consultaIdSecretaria = "SELECT id_secretaria FROM tb_secretaria WHERE nome_secretaria = ?";
    $stmt = $conn->prepare($consultaIdSecretaria);
    $stmt->bind_param('s', $nomeSecretaria);
    $stmt->execute();
    $resultIdSecretaria = $stmt->get_result();

    if ($resultIdSecretaria && $resultIdSecretaria->num_rows > 0) {
        $row = $resultIdSecretaria->fetch_assoc();
        $idSecretaria = $row['id_secretaria'];

        $consultaExistencia = "SELECT COUNT(*) AS total FROM tb_secretaria WHERE nome_secretaria = ?";
        $stmt2 = $conn->prepare($consultaExistencia);
        $stmt2->bind_param('s', $novoNomeSecretaria);
        $stmt2->execute();
        $resultExistencia = $stmt2->get_result();
        $rowExistencia = $resultExistencia->fetch_assoc();
        $total = $rowExistencia['total'];

        if ($total === 0) {
            $atualizarSecretaria = "UPDATE tb_secretaria SET nome_secretaria = ? WHERE id_secretaria = ?";
            $stmt3 = $conn->prepare($atualizarSecretaria);
            $stmt3->bind_param('si', $novoNomeSecretaria, $idSecretaria);
            $stmt3->execute();

            echo json_encode(array("status" => "success", "message" => "Secretaria renomeada com sucesso."));
        } else {
            echo json_encode(array("status" => "error", "message" => "Não foi possível renomear pois já existe outra secretaria com este nome."));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Secretaria não encontrada, tente novamente."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Método inválido para acessar esta página."));
}