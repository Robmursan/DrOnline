<?php
require_once '../../config/database.php';
require_once '../models/Paciente.php';

session_start();
$pacienteModel = new Paciente($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? null;

    if ($action == 'crear') {
        $id_medico = $_SESSION['id_medico'] ?? null;
        $nombre = $_POST['nombre'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $tipo_usuario = 'paciente';
        $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
        $sexo = $_POST['sexo'] ?? '';
        $direccion = $_POST['direccion'] ?? '';
        $telefono = $_POST['telefono'] ?? '';

        // Llama al método para registrar usuario y paciente
        $resultado = $pacienteModel->registrarUsuarioYPaciente($nombre, $email, $password, $tipo_usuario, $id_medico, $fecha_nacimiento, $sexo, $direccion, $telefono);

        // Verifica si la inserción fue exitosa
        if ($resultado) {
            echo "Paciente registrado correctamente con ID: $resultado";
        } else {
            echo "Error al registrar el paciente.";
        }
    }

    elseif ($action == 'actualizar') {
        $id_paciente = $_POST['id_paciente'] ?? null;
        $nombre = $_POST['nombre'] ?? '';
        $email = $_POST['email'] ?? '';
        $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
        $sexo = $_POST['sexo'] ?? '';
        $direccion = $_POST['direccion'] ?? '';
        $telefono = $_POST['telefono'] ?? '';

        // Llama al método para actualizar el paciente
        $resultado = $pacienteModel->actualizarPaciente($id_paciente, $nombre, $email, $fecha_nacimiento, $sexo, $direccion, $telefono);

        if ($resultado) {
            echo "Paciente actualizado correctamente.";
        } else {
            echo "Error al actualizar el paciente.";
        }
    }

    elseif ($action == 'eliminar') {
        $id_paciente = $_POST['id_paciente'] ?? null;

        // Llama al método para eliminar el paciente
        $resultado = $pacienteModel->eliminarPaciente($id_paciente);

        if ($resultado) {
            echo "Paciente eliminado correctamente.";
        } else {
            echo "Error al eliminar el paciente.";
        }
    }
}


