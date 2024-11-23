<?php
require_once '../../config/database.php';
require_once '../models/Tratamiento.php';

session_start();
$id_medico = $_SESSION['id_medico']; // Asegúrate de que el ID del médico esté en la sesión
$tratamientoModel = new Tratamiento($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == 'crear') {
        $id_paciente = $_POST['id_paciente'];
        $descripcion = $_POST['descripcion'];
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];
        $estado = $_POST['estado'];
        $tratamientoModel->crearTratamiento($id_medico, $id_paciente, $descripcion, $fecha_inicio, $fecha_fin, $estado);

    } elseif ($action == 'actualizar') {
        $id_tratamiento = $_POST['id_tratamiento'];
        $descripcion = $_POST['descripcion'];
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];
        $estado = $_POST['estado'];
        $tratamientoModel->actualizarTratamiento($id_tratamiento, $descripcion, $fecha_inicio, $fecha_fin, $estado);

    } elseif ($action == 'eliminar') {
        $id_tratamiento = $_POST['id_tratamiento'];
        $tratamientoModel->eliminarTratamiento($id_tratamiento);
    }
}
