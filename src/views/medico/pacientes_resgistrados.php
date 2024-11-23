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
$pacientes = $pacienteModel->obtenerPacientesConRegistrosYTratamientos($id_medico);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pacientes Registrados</title>
    <style>
        .menu-desplegable {
            display: inline-block;
            position: relative;
        }

        .menu-desplegable-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .menu-desplegable:hover .menu-desplegable-content {
            display: block;
        }

        .menu-desplegable-content a,
        .menu-desplegable-content button {
            padding: 10px;
            text-decoration: none;
            display: block;
            border: none;
            background: none;
            cursor: pointer;
        }

        .menu-desplegable-content a:hover,
        .menu-desplegable-content button:hover {
            background-color: #f1f1f1;
        }

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

        .btn:hover {
            background-color: #006F8E;
        }
    </style>
</head>
<body>
    <h1>Pacientes Registrados</h1>
    <p><a href="/DrOnline/src/views/medico/registrar_paciente.php" class="btn">Agregar Nuevo Paciente</a></p>
    <table>
        <thead>
            <tr>
                <th>ID Paciente</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Últimos Registros Médicos</th>
                <th>Tratamientos Asignados</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($pacientes)): ?>
                <tr>
                    <td colspan="8">No hay pacientes registrados.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($pacientes as $paciente): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($paciente['id_paciente']); ?></td>
                        <td><?php echo htmlspecialchars($paciente['nombre_paciente']); ?></td>
                        <td><?php echo htmlspecialchars($paciente['email_paciente']); ?></td>
                        <td><?php echo htmlspecialchars($paciente['direccion']); ?></td>
                        <td><?php echo htmlspecialchars($paciente['telefono']); ?></td>
                        <td>
                            Tensión Arterial: <?php echo htmlspecialchars($paciente['tension_arterial'] ?? 'N/A'); ?><br>
                            Glicemia: <?php echo htmlspecialchars($paciente['glicemia'] ?? 'N/A'); ?><br>
                            Síntomas: <?php echo htmlspecialchars($paciente['sintomas'] ?? 'N/A'); ?><br>
                        </td>
                        <td>
                            <a href="/DrOnline/src/views/medico/tratamientos_asignados.php?id_paciente=<?php echo $paciente['id_paciente']; ?>" class="btn">Ver Tratamientos</a>
                        </td>
                        <td>
                            <div class="menu-desplegable">
                                <button>Opciones</button>
                                <div class="menu-desplegable-content">
                                    <a href="/DrOnline/src/views/medico/asignar_tratamiento.php?id_paciente=<?php echo htmlspecialchars($paciente['id_paciente']); ?>">Asignar Tratamiento</a>
                                    <a href="/DrOnline/src/views/medico/asignar_cita.php?id_paciente=<?php echo htmlspecialchars($paciente['id_paciente']); ?>">Asignar Cita</a>
                                    <a href="/DrOnline/src/views/medico/editar_paciente.php?id_paciente=<?php echo htmlspecialchars($paciente['id_paciente']); ?>">Editar</a>
                                    <a href="../../controllers/pacientesController.php?action=eliminar&id_paciente=<?php echo htmlspecialchars($paciente['id_paciente']); ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este paciente?');">Eliminar</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
