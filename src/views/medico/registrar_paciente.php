<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Paciente</title>
</head>
<body>
    <h1>Registrar Nuevo Paciente</h1>
    <form action="../../controllers/pacientesController.php" method="post">
        <input type="hidden" name="action" value="crear">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required><br>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" required><br>

        <label for="sexo">Sexo:</label>
        <input type="text" name="sexo" required><br>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" required><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" required><br>

        <button type="submit">Registrar Paciente</button>
    </form>
</body>
</html>
