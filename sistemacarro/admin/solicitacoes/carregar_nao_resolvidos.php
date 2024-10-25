<?php
include ('../../inc/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $resolvido = 0;

    $sql = "SELECT l.nome, l.matricula, se.nome_setor, s.id_solicitacao, s.tipo, s.texto, s.data_solicitacao FROM tb_solicitacoes s
            INNER JOIN tb_login l ON l.id_login = s.solicitador
            INNER JOIN tb_setor se ON se.id_setor = l.setor
            WHERE resolvido = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $resolvido);
    $stmt->execute();
    $result = $stmt->get_result();

    $solicitacoes = array();
    while ($row = $result->fetch_assoc()) {
        $tipo = $row['tipo'];
        $data_solicitacao = $row['data_solicitacao'];

        unset($row['data_solicitacao']);

        $data_solicitacao_formatada = date('d-m-Y | H:i', strtotime($data_solicitacao));
        
        $row['data_solicitacao'] = $data_solicitacao_formatada;

        if ($tipo == 1) {
            $texto = $row['texto'];
            $textoSeparado = explode(" / ", $texto);

            if (count($textoSeparado) >= 2) {
                $matricula = $textoSeparado[0];
                $setor = $textoSeparado[1];

                $row['matricula'] = $matricula;
                $row['setor'] = $setor;

                unset($row['texto']);

                $solicitacoes[] = $row;
            }
        } elseif ($tipo == 2 || $tipo == 4) {
            $solicitacoes[] = $row;
        } else {
            $getPlaca = "SELECT placa, modelo FROM tb_veiculo WHERE id_veiculo = ?";
            $stmt2 = $conn->prepare($getPlaca);
            $stmt2->bind_param('i', $row['texto']);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            if ($row2 = $result2->fetch_assoc()) {
                $row['veiculo'] = $row2['placa'] . " / " . $row2['modelo'];
                $solicitacoes[] = $row;
            }
            $stmt2->close();
        }
    }

    $stmt->close();
    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($solicitacoes);
}