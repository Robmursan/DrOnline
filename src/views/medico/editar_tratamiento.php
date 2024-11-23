<?php
require_once '../../../config/database.php';
require_once '../../models/Tratamiento.php';

session_start();
$id_medico = $_SESSION['id_medico'] ?? null;

// Verifica si el médico está autenticado
if (!$id_medico) {
    echo '<script type="text/javascript">';
    echo 'alert("Error: No se ha especificado un médico válido.");';
    echo 'window.location.href = "/DrOnline/src/views/medico/pacientes_resgistrados.php";';
    echo '</script>';
    exit;
}

// Verifica que se haya enviado el ID del tratamiento
$id_tratamiento = $_GET['id_tratamiento'] ?? null;

if (!$id_tratamiento) {
    echo '<script type="text/javascript">';
    echo 'alert("Error: No se ha especificado el ID del tratamiento.");';
    echo 'window.location.href = "/DrOnline/src/views/medico/pacientes_resgistrados.php";';
    echo '</script>';
    exit;
}

$tratamientoModel = new Tratamiento($conn);

// Obtén los datos actuales del tratamiento
$tratamiento = $tratamientoModel->obtenerTratamientoPorId($id_tratamiento);

// Verifica que el tratamiento exista
if (!$tratamiento) {
    echo '<script type="text/javascript">';
    echo 'alert("Error: El tratamiento no existe.");';
    echo 'window.location.href = "/DrOnline/src/views/medico/pacientes_resgistrados.php";';
    echo '</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Tratamiento</title>
</head>
<body>
    <h1>Editar Tratamiento</h1>
    <form action="../../controllers/tratamientosController.php" method="post">
        <!-- Enviar los valores necesarios -->
        <input type="hidden" name="action" value="actualizar">
        <input type="hidden" name="id_tratamiento" value="<?php echo htmlspecialchars($tratamiento['id_tratamiento']); ?>">

        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" value="<?php echo htmlspecialchars($tratamiento['descripcion']); ?>" required><br>

        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" value="<?php echo htmlspecialchars($tratamiento['fecha_inicio']); ?>" required><br>

        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="date" name="fecha_fin" value="<?php echo htmlspecialchars($tratamiento['fecha_fin']); ?>" required><br>

        <label for="estado">Estado:</label>
        <select name="estado" required>
            <option value="activo" <?php echo $tratamiento['estado'] === 'activo' ? 'selected' : ''; ?>>Activo</option>
            <option value="completado" <?php echo $tratamiento['estado'] === 'completado' ? 'selected' : ''; ?>>Completado</option>
        </select><br>

        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
    