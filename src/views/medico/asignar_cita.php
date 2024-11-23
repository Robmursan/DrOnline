<?php
require_once '../../../config/database.php';

$id_paciente = $_POST['id_paciente'] ?? null;

$id_paciente = $_GET['id_paciente'] ?? null;

if (!$id_paciente) {
    echo "Error: No se ha especificado el ID del paciente.";
    exit;
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Cita</title>
</head>
<body>
    <h1>Asignar Cita al Paciente</h1>
    <form action="guardar_cita.php" method="post">
        <input type="hidden" name="id_paciente" value="<?php echo htmlspecialchars($id_paciente); ?>">
        
        <label for="fecha">Fecha de la Cita:</label>
        <input type="date" name="fecha" required><br>

        <label for="hora">Hora de la Cita:</label>
        <input type="time" name="hora" required><br>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion"></textarea><br>

        <button type="submit">Asignar Cita</button>
    </form>
</body>
</html>
