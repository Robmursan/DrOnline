<?php
require_once '../../config/database.php';
require_once '../models/Paciente.php';

ob_start(); // Inicia el buffer de salida
session_start();
$pacienteModel = new Paciente($conn);

$action = $_GET['action'] ?? $_POST['action'] ?? null; // Definir $action desde GET o POST

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Registrar o actualizar paciente
    if ($action === 'crear') {
        $id_medico = $_SESSION['id_medico'] ?? null;
        $nombre = $_POST['nombre'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $tipo_usuario = 'paciente';
        $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
        $sexo = $_POST['sexo'] ?? '';
        $direccion = $_POST['direccion'] ?? '';
        $telefono = $_POST['telefono'] ?? '';

        // Intentar registrar un nuevo paciente
        $resultado = $pacienteModel->registrarUsuarioYPaciente(
            $nombre,
            $email,
            $password,
            $tipo_usuario,
            $id_medico,
            $fecha_nacimiento,
            $sexo,
            $direccion,
            $telefono
        );

        if ($resultado) {
            // Redirige a la vista pacientes_registrados.php
             echo "Error al registrar el paciente.";
        } else {
            // Muestra un mensaje en caso de error
            //echo "Error al registrar el paciente.";
            header('Location: /DrOnline/src/views/medico/pacientes_resgistrados.php');
            exit; // Finaliza la ejecución para evitar que se ejecute más código después de la redirección
        }
        
    } elseif ($action === 'actualizar') {
        $id_paciente = $_POST['id_paciente'] ?? null;
        $nombre = $_POST['nombre'] ?? '';
        $email = $_POST['email'] ?? '';
        $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
        $sexo = $_POST['sexo'] ?? '';
        $direccion = $_POST['direccion'] ?? '';
        $telefono = $_POST['telefono'] ?? '';

        // Intentar actualizar un paciente existente
        $resultado = $pacienteModel->actualizarPaciente(
            $id_paciente,
            $nombre,
            $email,
            $fecha_nacimiento,
            $sexo,
            $direccion,
            $telefono
        );

        if ($resultado) {
            header('Location: /DrOnline/src/views/medico/pacientes_resgistrados.php');
            exit;
        } else {
            echo "Error al actualizar el paciente.";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if ($action === 'eliminar') {
        $id_paciente = filter_var($_GET['id_paciente'], FILTER_VALIDATE_INT);

        if ($id_paciente) {
            // Intentar eliminar el paciente
            $resultado = $pacienteModel->eliminarPaciente($id_paciente);

            if ($resultado) {
                //header('Location: ../views/medico/pacientes_registrados.php');
                header('Location: /DrOnline/src/views/medico/pacientes_resgistrados.php');

                exit;
            } else {
                echo "Error al eliminar el paciente.";
            }
        } else {
            echo "Error: No se proporcionó un ID de paciente válido.";
        }
    }
}

ob_end_flush(); // Envía el contenido del buffer al navegador
?>
