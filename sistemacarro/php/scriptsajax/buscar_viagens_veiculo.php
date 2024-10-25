<?php

include ('../../inc/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $veiculo = $_POST['veiculo'];

    $query = "SELECT id_viagem, datahora FROM tb_viagem WHERE id_veiculo = ? ORDER BY datahora DESC";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $veiculo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $token, $datahora);

    $options = '';
    while (mysqli_stmt_fetch($stmt)) {
        $datahora_formatada = date('d-m-Y', strtotime($datahora)) . ' ' . date('H:i', strtotime($datahora));
        $options .= '<a class="list-group-item list-group-item-action" onclick="buscarCoordenadasVeiculo(' . $token . ')" data-bs-toggle="list" href="#">' . $datahora_formatada . '</a>';
    }

    mysqli_stmt_close($stmt);

    echo $options;
}