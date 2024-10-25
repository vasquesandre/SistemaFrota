<?php

include ('../../inc/conexao.php');

session_start();

$perfil = $_SESSION['id_perfil'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($perfil == 1) {
        $query = "SELECT id_veiculo, placa, modelo FROM tb_veiculo ORDER BY placa ASC";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $token, $placa, $modelo);

        $options = '';

        while (mysqli_stmt_fetch($stmt)) {
            $options .= '<option value="' . $token . '">' . $placa . ' / ' . $modelo . '</option>';
        }

        mysqli_stmt_close($stmt);

        echo $options;

    } else {

        $id_secretaria = $_SESSION['secretaria'];

        $query = "SELECT v.id_veiculo, v.placa, v.modelo FROM tb_veiculo v 
                    INNER JOIN tb_login l ON l.id_login = v.id_login
                    WHERE l.secretaria = '$id_secretaria'
                    ORDER BY v.placa ASC";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $token, $placa, $modelo);

        $options = '';

        while (mysqli_stmt_fetch($stmt)) {
            $options .= '<option value="' . $token . '">' . $placa . ' / ' . $modelo . '</option>';
        }

        mysqli_stmt_close($stmt);

        echo $options;

    }
}