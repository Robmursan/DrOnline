<?php
require_once '../../config/database.php';
require_once '../models/Tratamiento.php';

session_start();
$id_medico = $_SESSION['id_medico'] ?? null; // Asegúrate de que el ID del médico esté en la sesión

if (!$id_medico) {
    echo "Error: No se ha especificado el ID del médico.";
    exit;
}

$tratamientoModel = new Tratamiento($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? null;

    if ($action === 'crear') {
        $id_paciente = $_POST['id_paciente'] ?? null;
        $descripcion = $_POST['descripcion'] ?? '';
        $fecha_inicio = $_POST['fecha_inicio'] ?? '';
        $fecha_fin = $_POST['fecha_fin'] ?? '';
        $estado = $_POST['estado'] ?? '';

        // Validar que todos los campos necesarios están presentes
        if ($id_paciente && $descripcion && $fecha_inicio && $fecha_fin && $estado) {
            $resultado = $tratamientoModel->crearTratamiento($id_medico, $id_paciente, $descripcion, $fecha_inicio, $fecha_fin, $estado);

            if ($resultado) {
                header("Location: ../views/medico/tratamientos_asignados.php");
                exit;
            } else {
                echo "Error al crear el tratamiento.";
            }
        } else {
            echo "Por favor, completa todos los campos.";
        }

    } elseif ($action === 'actualizar') {
        $id_tratamiento = $_POST['id_tratamiento'] ?? null;
        $descripcion = $_POST['descripcion'] ?? '';
        $fecha_inicio = $_POST['fecha_inicio'] ?? '';
        $fecha_fin = $_POST['fecha_fin'] ?? '';
        $estado = $_POST['estado'] ?? '';

        if ($id_tratamiento && $descripcion && $fecha_inicio && $fecha_fin && $estado) {
            $resultado = $tratamientoModel->actualizarTratamiento($id_tratamiento, $descripcion, $fecha_inicio, $fecha_fin, $estado);

            if ($resultado) {
                header("Location: ../views/medico/tratamientos_asignados.php");
                exit;
            } else {
                echo "Error al actualizar el tratamiento.";
            }
        } else {
            echo "Por favor, completa todos los campos.";
        }

    } elseif ($action === 'eliminar') {
        $id_tratamiento = $_POST['id_tratamiento'] ?? null;

        if ($id_tratamiento) {
            $resultado = $tratamientoModel->eliminarTratamiento($id_tratamiento);

            if ($resultado) {
                header("Location: ../views/medico/tratamientos_asignados.php");
                exit;
            } else {
                echo "Error al eliminar el tratamiento.";
            }
        } else {
            echo "No se ha especificado el ID del tratamiento a eliminar.";
        }
    }
} else {
    // Si es una solicitud GET, mostrar los tratamientos asignados
    $tratamientos = $tratamientoModel->obtenerTratamientosPorMedico($id_medico);
    include '../views/medico/tratamientos_asignados.php';
}
?>
