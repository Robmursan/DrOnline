<?php
require_once '../../../config/database.php';
require_once '../../models/Tratamiento.php';


session_start();
$id_medico = $_SESSION['id_medico'];
$tratamientoModel = new Tratamiento($conn);
$tratamientos = $tratamientoModel->obtenerTratamientosPorMedico($id_medico);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tratamientos</title>
</head>
<body>
    <h1>Tratamientos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tratamientos as $tratamiento): ?>
                <tr>
                    <td><?php echo $tratamiento['id_tratamiento']; ?></td>
                    <td><?php echo $tratamiento['descripcion']; ?></td>
                    <td><?php echo $tratamiento['fecha_inicio']; ?></td>
                    <td><?php echo $tratamiento['fecha_fin']; ?></td>
                    <td><?php echo $tratamiento['estado']; ?></td>
                    <td>
                        <<form action="editar_tratamiento.php" method="post">
                        <input type="hidden" name="id_tratamiento" value="<?php echo $tratamiento['id_tratamiento']; ?>">
                        <button type="submit">Editar</button>
                        </form>
                        <form action="../../controllers/tratamientosController.php" method="post">
                            <input type="hidden" name="action" value="eliminar">
                            <input type="hidden" name="id_tratamiento" value="<?php echo $tratamiento['id_tratamiento']; ?>">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Agregar Tratamiento</h2>
    <form action="../../controllers/tratamientosController.php" method="post">
        <input type="hidden" name="action" value="crear">
        <input type="hidden" name="id_medico" value="<?php echo $id_medico; ?>">
        <label for="id_paciente">ID Paciente:</label>
        <input type="number" name="id_paciente" required><br>

        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" required><br>

        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" required><br>

        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="date" name="fecha_fin" required><br>

        <label for="estado">Estado:</label>
        <input type="text" name="estado" required><br>

        <button type="submit">Agregar Tratamiento</button>
    </form>
</body>
</html>
