<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>
<nav>
    <a href="../auth/login.php">Inicio</a>
    <a href="../medico/dashboard.php">Dashboard</a>
</nav>
