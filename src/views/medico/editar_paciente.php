<?php
require_once '../../../config/database.php';
require_once '../../models/Paciente.php';

$id_paciente = $_GET['id_paciente'] ?? null;

if (!$id_paciente) {
    echo "Error: No se ha especificado el ID del paciente.";
    exit;
}

$pacienteModel = new Paciente($conn);
$paciente = $pacienteModel->obtenerPacientePorId($id_paciente);

if (!$paciente) {
    echo "Error: Paciente no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Paciente</title>
</head>
<body>
    <h1>Editar Paciente</h1>
    <form action="../../controllers/pacientesController.php" method="post">
        <input type="hidden" name="action" value="actualizar">
        <input type="hidden" name="id_paciente" value="<?php echo htmlspecialchars($paciente['id_paciente']); ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($paciente['nombre_paciente']); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($paciente['email_paciente']); ?>" required><br>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" value="<?php echo htmlspecialchars($paciente['fecha_nacimiento']); ?>" required><br>

        <label for="sexo">Sexo:</label>
        <select name="sexo" required>
            <option value="M" <?php echo $paciente['sexo'] === 'M' ? 'selected' : ''; ?>>Masculino</option>
            <option value="F" <?php echo $paciente['sexo'] === 'F' ? 'selected' : ''; ?>>Femenino</option>
        </select><br>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" value="<?php echo htmlspecialchars($paciente['direccion']); ?>" required><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" value="<?php echo htmlspecialchars($paciente['telefono']); ?>" required><br>

        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>

