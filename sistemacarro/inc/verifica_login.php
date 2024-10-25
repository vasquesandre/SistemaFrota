<?php
if (!isset($_SESSION['user'])) {
    echo "<script>
        window.location.href = '../../../sistemacarro/html/login/login.php'
        </script>";
    exit;
}