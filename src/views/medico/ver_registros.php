<?php
require_once '../../../config/database.php';
require_once '../../models/RegistroMedico.php';

$id_paciente = $_GET['id_paciente'] ?? null;

if (!$id_paciente) {
    echo "Error: No se ha especificado el ID del paciente.";
    exit;
}

$registroModel = new RegistroMedico($conn);
$registros = $registroModel->obtenerRegistrosPorPaciente($id_paciente);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registros Médicos</title>
</head>
<body>
    <h1>Registros Médicos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tensión Arterial</th>
                <th>Glicemia</th>
                <th>Síntomas</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registros as $registro): ?>
                <tr>
                    <td><?php echo htmlspecialchars($registro['fecha_registro']); ?></td>
                    <td><?php echo htmlspecialchars($registro['tension_arterial']); ?></td>
                    <td><?php echo htmlspecialchars($registro['glicemia']); ?></td>
                    <td><?php echo htmlspecialchars($registro['sintomas']); ?></td>
                    <td><?php echo htmlspecialchars($registro['descripcion']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
