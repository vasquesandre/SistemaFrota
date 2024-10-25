<?php

include ('../../inc/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];

    $query = "SELECT coordenadas FROM tb_login WHERE id_login = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $coordenadas);

    $options = array();

    $options['coordenadas'] = 'var markers = [];';

    while (mysqli_stmt_fetch($stmt)) {
        $options['coordenadas'] .= 'var marker = L.marker([' . $coordenadas . ']).addTo(map); markers.push(marker);';
    }

    mysqli_stmt_close($stmt);

    echo json_encode($options);
}