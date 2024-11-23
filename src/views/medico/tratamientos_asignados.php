<?php
require_once '../../../config/database.php';
require_once '../../models/Tratamiento.php';

// Capturar el ID del paciente desde la URL
$id_paciente = $_GET['id_paciente'] ?? null;

if (!$id_paciente) {
    echo '<script type="text/javascript">';
    echo 'alert("Error: No se ha especificado un ID de paciente válido.");';
    echo 'window.location.href = "/DrOnline/src/views/medico/pacientes_resgistrados.php";';
    echo '</script>';
    exit;
}

$tratamientoModel = new Tratamiento($conn);
$tratamientos = $tratamientoModel->obtenerTratamientosPorPaciente($id_paciente);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tratamientos del Paciente</title>
    <style>
        /* Estilos para la tabla y botones */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 5px 10px;
            text-decoration: none;
            background-color: #008CBA;
            color: white;
            border-radius: 4px;
            margin-right: 5px;
        }

        .btn-danger {
            background-color: #f44336;
        }

        .btn:hover {
            background-color: #006F8E;
        }

        .btn-danger:hover {
            background-color: #da190b;
        }
    </style>
</head>
<body>
    <h1>Tratamientos Asignados al Paciente</h1>
    <!-- Enlace para asignar un nuevo tratamiento -->
    <p><a href="crear_tratamiento.php?id_paciente=<?php echo htmlspecialchars($id_paciente); ?>" class="btn">Asignar Nuevo Tratamiento</a></p>
    <?php if (empty($tratamientos)): ?>
        <p>No hay tratamientos asignados a este paciente.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID Tratamiento</th>
                    <th>Descripción</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tratamientos as $tratamiento): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($tratamiento['id_tratamiento']); ?></td>
                        <td><?php echo htmlspecialchars($tratamiento['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($tratamiento['fecha_inicio']); ?></td>
                        <td><?php echo htmlspecialchars($tratamiento['fecha_fin']); ?></td>
                        <td><?php echo htmlspecialchars($tratamiento['estado']); ?></td>
                        <td>
                            <!-- Botones de acción -->
                            <a href="editar_tratamiento.php?id_tratamiento=<?php echo $tratamiento['id_tratamiento']; ?>" class="btn">Editar</a>
                            <form action="../../controllers/tratamiento.php" method="post" style="display:inline;">
                                <input type="hidden" name="action" value="eliminar">
                                <input type="hidden" name="id_tratamiento" value="<?php echo $tratamiento['id_tratamiento']; ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este tratamiento?');">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <!-- Enlace para volver a la lista de pacientes -->
    <p><a href="/DrOnline/src/views/medico/pacientes_resgistrados.php" class="btn">Volver a Pacientes</a></p>
</body>
</html>
