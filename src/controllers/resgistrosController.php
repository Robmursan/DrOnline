<?php
require_once '../../config/database.php';
require_once '../models/RegistroMedico.php';

session_start();
$registroModel = new RegistroMedico($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? null;

    if ($action == 'crear') {
        $id_paciente = $_POST['id_paciente'];
        $tension_arterial = $_POST['tension_arterial'];
        $glicemia = $_POST['glicemia'];
        $sintomas = implode(', ', $_POST['sintomas']); // Convierte el array de síntomas en texto
        $descripcion = $_POST['descripcion'];

        $resultado = $registroModel->crearRegistro($id_paciente, $tension_arterial, $glicemia, $sintomas, $descripcion);

        if ($resultado) {
            echo "Registro médico creado correctamente.";
        } else {
            echo "Error al crear el registro médico.";
        }
    }
}
?>
