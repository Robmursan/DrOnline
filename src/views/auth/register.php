<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Médico</title>
    <link rel="stylesheet" href="../../public/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Registro de Médico</h2>
        <form action="../../controllers/authController.php" method="POST">
            <input type="hidden" name="action" value="register">
            
            <label for="nombre">Nombre Completo:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <!-- Campo oculto para establecer el tipo de usuario como 'medico' -->
            <input type="hidden" name="tipo_usuario" value="medico">

            <label for="especialidad">Especialidad:</label>
            <input type="text" id="especialidad" name="especialidad" required>

            <label for="numero_colegiado">Número de Colegiado:</label>
            <input type="text" id="numero_colegiado" name="numero_colegiado" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>

            <button type="submit">Registrar Médico</button>
        </form>
    </div>
</body>
</html>

