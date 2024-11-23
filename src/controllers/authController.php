<?php
session_start();
require_once '../../config/database.php';
require_once '../models/Usuario.php';
require_once '../models/Medico.php'; // Incluye el modelo Medico para registrar médicos y obtener el ID

/**
 * Función para iniciar sesión
 *
 * @param string $email - Correo electrónico ingresado por el usuario
 * @param string $password - Contraseña ingresada por el usuario
 */
function iniciarSesion($email, $password) {
    global $conn; // Usa la conexión a la base de datos.
    
    $usuarioModel = new Usuario($conn);
    $medicoModel = new Medico($conn);
    
    // Verifica las credenciales llamando al método login en Usuario
    $usuario = $usuarioModel->login($email, $password);

    if ($usuario) { // Si las credenciales son correctas:
        // Guarda el ID y tipo de usuario en la sesión
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

        // Si el usuario es de tipo médico, obtenemos y almacenamos su ID de médico en la sesión
        if ($usuario['tipo_usuario'] === 'medico') {
            $id_usuario = $usuario['id_usuario'];
            $id_medico = $medicoModel->obtenerIdMedico($id_usuario); // Método para obtener el ID de médico
            $_SESSION['id_medico'] = $id_medico; // Almacena el ID de médico en la sesión
        }
        
        // Redirige al dashboard
        header("Location: ../../src/views/medico/dashboard.php");
        exit();
    } else {
        echo "Credenciales incorrectas. <a href='../../src/views/auth/login.php'>Intentar de nuevo</a>";
    }
}

/**
 * Función para registrar usuario y médico
 */
function registrarUsuario($nombre, $email, $password, $tipo_usuario, $especialidad, $numero_colegiado, $telefono) {
    global $conn;
    
    $usuarioModel = new Usuario($conn);
    $medicoModel = new Medico($conn);

    // Crea el usuario
    $resultadoUsuario = $usuarioModel->register($nombre, $email, $password, $tipo_usuario);

    if ($resultadoUsuario) {
        // Obtiene el ID de usuario recién creado
        $id_usuario = $conn->lastInsertId();

        if ($tipo_usuario === 'medico') {
            // Crea el registro de médico en la tabla medicos
            $resultadoMedico = $medicoModel->crearMedico($id_usuario, $especialidad, $numero_colegiado, $telefono);
            
            if ($resultadoMedico) {
                // Guarda el ID de médico en la sesión
                $_SESSION['id_medico'] = $conn->lastInsertId(); // Guarda el ID de médico para mostrarlo
                echo "Registro exitoso. ID de Médico: " . $_SESSION['id_medico'] . ". <a href='../../src/views/auth/login.php'>Iniciar sesión</a>";
            } else {
                echo "Error al crear el registro del médico.";
            }
        }
    } else {
        echo "Error en el registro del usuario.";
    }
}

// Procesa la solicitud de registro o inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        iniciarSesion($email, $password);
    } elseif ($action == 'register') {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $tipo_usuario = $_POST['tipo_usuario'];
        $especialidad = $_POST['especialidad'];
        $numero_colegiado = $_POST['numero_colegiado'];
        $telefono = $_POST['telefono'];

        registrarUsuario($nombre, $email, $password, $tipo_usuario, $especialidad, $numero_colegiado, $telefono);
    }
}
?>
