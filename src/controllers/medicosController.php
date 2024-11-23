<?php
require_once '../../config/database.php';
require_once '../models/Medico.php';

$medicoModel = new Medico($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == 'crear_medico') {
        $id_usuario = $_POST['id_usuario'];
        $especialidad = $_POST['especialidad'];
        $numero_colegiado = $_POST['numero_colegiado'];
        $telefono = $_POST['telefono'];
        $medicoModel->crearMedico($id_usuario, $especialidad, $numero_colegiado, $telefono);
        echo "Médico creado exitosamente";
    }
}
?>
