<?php
require_once 'config/database.php';
require_once 'src/models/Paciente.php';

$conn = new PDO("mysql:host=localhost;dbname=DrOnline03", "root", "");
$pacienteModel = new Paciente($conn);

$nombre = "Juan Pérez";
$email = "juan.perez@example.com";
$password = "password123";
$tipo_usuario = "paciente";
$id_medico = 1; // Cambia esto a un ID de médico válido
$fecha_nacimiento = "1990-01-01";
$sexo = "M";
$direccion = "Calle Falsa 123";
$telefono = "555-1234";

$resultado = $pacienteModel->registrarUsuarioYPaciente($nombre, $email, $password, $tipo_usuario, $id_medico, $fecha_nacimiento, $sexo, $direccion, $telefono);

if ($resultado) {
    echo "Paciente registrado correctamente con ID: $resultado";
} else {
    echo "Error al registrar el paciente.";
}
