<?php

if (!isset($_SESSION)) {
    session_start();
}

if ($_SESSION['id_perfil'] == 3) {
    echo "<script>
        window.location.href = '../../../sistemacarro/index.php'
        </script>";
    exit;
}