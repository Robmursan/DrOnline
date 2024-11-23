<?php
require_once '../../../config/database.php';
require_once '../../models/Tratamiento.php';

session_start();
$id_medico = $_SESSION['id_medico'];

// Verifica que se haya enviado el ID del tratamiento a editar
if (!isset($_POST['id_tratamiento'])) {
    echo "Error: No se ha especificado el ID del tratamiento.";
    exit;
}

$id_tratamiento = $_POST['id_tratamiento'];
$tratamientoModel = new Tratamiento($conn);

// Obtén los datos actuales del tratamiento
$tratamiento = $tratamientoModel->obtenerTratamientoPorId($id_tratamiento);

// Verifica que el tratamiento exista
if (!$tratamiento) {
    echo "Error: El tratamiento no existe.";
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
        <input type="hidden" name="action" value="actualizar">
        <input type="hidden" name="id_tratamiento" value="<?php echo $tratamiento['id_tratamiento']; ?>">

        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" value="<?php echo $tratamiento['descripcion']; ?>" required><br>

        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" value="<?php echo $tratamiento['fecha_inicio']; ?>" required><br>

        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="date" name="fecha_fin" value="<?php echo $tratamiento['fecha_fin']; ?>" required><br>

        <label for="estado">Estado:</label>
        <input type="text" name="estado" value="<?php echo $tratamiento['estado']; ?>" required><br>

        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
