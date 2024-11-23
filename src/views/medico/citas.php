<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Citas</title>
</head>
<body>
    <h2>Gestión de Citas</h2>
    <form action="../../controllers/citasController.php" method="POST">
        <input type="hidden" name="action" value="crear_cita">
        <label for="id_paciente">ID del Paciente:</label>
        <input type="text" id="id_paciente" name="id_paciente" required>
        <label for="id_medico">ID del Médico:</label>
        <input type="text" id="id_medico" name="id_medico" required>
        <label for="fecha">Fecha de la Cita:</label>
        <input type="date" id="fecha" name="fecha" required>
        <label for="motivo">Motivo:</label>
        <textarea id="motivo" name="motivo" required></textarea>
        <button type="submit">Agendar Cita</button>
    </form>
</body>
</html>
