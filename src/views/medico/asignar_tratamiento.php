<?php
require_once '../../../config/database.php';

$id_paciente = $_GET['id_paciente'] ?? null;

if (!$id_paciente) {
    echo "Error: No se ha especificado el ID del paciente.";
    exit;
}

// echo "Asignar tratamiento al paciente con ID: $id_paciente";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Tratamiento</title>
</head>
<body>
    <h1>Asignar Tratamiento al Paciente</h1>
    <form action="guardar_tratamiento.php" method="post">
        <input type="hidden" name="id_paciente" value="<?php echo htmlspecialchars($id_paciente); ?>">
        
        <label for="descripcion">Descripción del Tratamiento:</label>
        <textarea name="descripcion" required></textarea><br>

        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" required><br>

        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="date" name="fecha_fin" required><br>

        <label for="estado">Estado:</label>
        <select name="estado" required>
            <option value="activo">Activo</option>
            <option value="completado">Completado</option>
        </select><br>

        <button type="submit">Asignar Tratamiento</button>
    </form>
</body>
</html>
