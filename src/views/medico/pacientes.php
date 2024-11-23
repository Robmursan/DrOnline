<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Paciente</title>
</head>
<body>
    <div class="container">
        <h2>Registro de Paciente</h2>

        <?php
        session_start();
        if (!isset($_SESSION['id_medico'])) {
            header("Location: ../../auth/login.php");
            exit();
        }
        $id_medico = $_SESSION['id_medico'];
        ?>

        <form action="../../controllers/pacientesController.php" method="POST">
            <input type="hidden" name="action" value="crear_paciente">
            <input type="hidden" name="id_medico" value="<?php echo $id_medico; ?>">

            <!-- Datos de Usuario -->
            <label for="nombre">Nombre Completo:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <!-- Datos del Paciente -->
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>

            <label for="sexo">Sexo:</label>
            <select id="sexo" name="sexo" required>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
                <option value="O">Otro</option>
            </select>

            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>

            <button type="submit">Registrar Paciente</button>
        </form>
    </div>
</body>
</html>

