<?php
require_once '../../config/database.php';
require_once '../models/Cita.php';

$citaModel = new Cita($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == 'crear_cita') {
        $id_paciente = $_POST['id_paciente'];
        $id_medico = $_POST['id_medico'];
        $fecha = $_POST['fecha'];
        $motivo = $_POST['motivo'];
        $citaModel->crearCita($id_paciente, $id_medico, $fecha, $motivo);
        echo "Cita creada exitosamente";
    }
}
?>
