<?php

include ('../../inc/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $viagem_id = $_POST['index'];

    $query = "SELECT c.coordenadas, l.nome, l.matricula, v.km_inicial, v.km_final, v.destino, v.datahora, v.datahora_final FROM tb_coordenadas c 
            INNER JOIN tb_viagem v ON v.id_viagem = c.id_viagem
            INNER JOIN tb_login l ON v.id_login = l.id_login
            WHERE c.id_viagem = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $viagem_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $coordenadas, $motorista, $matricula, $km_inicial, $km_final, $destino, $horainicial, $horafinal);

    $options = array();
    $options['coordenadas'] = 'var markers = [];';
    while (mysqli_stmt_fetch($stmt)) {
        $options['coordenadas'] .= 'var marker = L.marker([' . $coordenadas . ']).addTo(map); markers.push(marker);';
    }
    $options['motorista'] = 'Motorista: <strong>' . $motorista . '</strong> / Matrícula: <strong>' . $matricula . '</strong>';
    $options['km'] = 'Km Inicial: <strong>' . $km_inicial . '</strong> - Km Final: <strong>' . $km_final . '</strong>';
    $options['destino'] = 'Destino: <strong>' . $destino . '</strong>';

    $options['km_total'] = 'Distância total do percurso: <strong>' . $km_final - $km_inicial . 'km</strong>';

    $hora_inicial = date('H:i:s', strtotime($horainicial));
    $hora_final = date('H:i:s', strtotime($horafinal));
    $diferenca = strtotime($horafinal) - strtotime($horainicial);

    $tempo_total = sprintf("%01d horas %01d minutos %01d segundos", ($diferenca/3600),($diferenca/60%60),($diferenca%60));

    mysqli_stmt_close($stmt);

    $options['tempo_total'] = 'Tempo total do percurso: <strong>' . $tempo_total . '</strong>';

    echo json_encode($options);
}