<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Registro Médico</title>
</head>
<body>
    <h1>Crear Registro Médico</h1>
    <form action="../../controllers/registrosController.php" method="post">
        <input type="hidden" name="action" value="crear">
        <input type="hidden" name="id_paciente" value="<?php echo htmlspecialchars($_GET['id_paciente']); ?>">

        <label for="tension_arterial">Tensión Arterial:</label>
        <input type="text" name="tension_arterial" placeholder="Ejemplo: 120/80" required><br>

        <label for="glicemia">Glicemia:</label>
        <input type="number" step="0.01" name="glicemia" placeholder="Ejemplo: 110.5" required><br>

        <label for="sintomas">Síntomas:</label><br>
        <input type="checkbox" name="sintomas[]" value="Mareos"> Mareos<br>
        <input type="checkbox" name="sintomas[]" value="Dolor de cabeza"> Dolor de cabeza<br>
        <input type="checkbox" name="sintomas[]" value="Sed excesiva"> Sed excesiva<br>
        <input type="checkbox" name="sintomas[]" value="Visión borrosa"> Visión borrosa<br>

        <label for="descripcion">Otros:</label><br>
        <textarea name="descripcion" rows="4" cols="50" placeholder="Describe otros síntomas o notas"></textarea><br>

        <button type="submit">Guardar Registro</button>
    </form>
</body>
</html>
