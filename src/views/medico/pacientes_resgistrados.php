<?php
require_once '../../../config/database.php';
require_once '../../models/Paciente.php';

session_start();
$id_medico = $_SESSION['id_medico'] ?? null;

if (!$id_medico) {
    echo "Error: No se ha especificado el ID del médico.";
    exit;
}

$pacienteModel = new Paciente($conn);
$pacientes = $pacienteModel->obtenerPacientesPorMedico($id_medico);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pacientes Registrados</title>
</head>
<body>
    <h1>Pacientes Registrados</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID Paciente</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Fecha de Nacimiento</th>
                <th>Sexo</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pacientes as $paciente): ?>
                <tr>
                    <td><?php echo htmlspecialchars($paciente['id_paciente']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['nombre_paciente']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['email_paciente']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['fecha_nacimiento']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['sexo']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['direccion']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['telefono']); ?></td>
                    <td>
                        <!-- Botón para Editar -->
                        <form action="editar_paciente.php" method="post" style="display:inline;">
                            <input type="hidden" name="id_paciente" value="<?php echo $paciente['id_paciente']; ?>">
                            <button type="submit">Editar</button>
                        </form>
                        
                        <!-- Botón para Eliminar -->
                        <form action="../../controllers/pacientesController.php" method="post" style="display:inline;">
                            <input type="hidden" name="action" value="eliminar">
                            <input type="hidden" name="id_paciente" value="<?php echo $paciente['id_paciente']; ?>">
                            <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este paciente?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

