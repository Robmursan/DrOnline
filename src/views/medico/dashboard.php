<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../auth/login.php");
    exit();
}

// Muestra el ID de médico desde la sesión, si está disponible
$id_medico = isset($_SESSION['id_medico']) ? $_SESSION['id_medico'] : "ID no disponible";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Médico</title>
    <link rel="stylesheet" href="../../public/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Bienvenido sea Dr/a.</h2>
        <p>ID de Médico: <?php echo $id_medico; ?></p>
        <nav>
            <ul>
                <li><a href="citas.php">Gestión de Citas</a></li>
                <li><a href="pacientes.php">Gestión de Pacientes</a></li>
                <li><a href="/DrOnline/src/views/medico/pacientes_resgistrados.php">Pacientes Registrados</a></li>
                <li><a href="tratamientos.php">Gestión de Tratamientos</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
