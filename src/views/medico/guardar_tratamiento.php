<?php
require_once '../../../config/database.php';

// Captura los datos enviados desde el formulario
$id_paciente = $_POST['id_paciente'] ?? null;
$descripcion = $_POST['descripcion'] ?? null;
$fecha_inicio = $_POST['fecha_inicio'] ?? null;
$fecha_fin = $_POST['fecha_fin'] ?? null;
$estado = $_POST['estado'] ?? null;

if (!$id_paciente || !$descripcion || !$fecha_inicio || !$fecha_fin || !$estado) {
    echo "Error: Todos los campos son obligatorios.";
    exit;
}

// Inserta el tratamiento en la base de datos
$query = "INSERT INTO tratamientos (id_paciente, descripcion, fecha_inicio, fecha_fin, estado)
          VALUES (:id_paciente, :descripcion, :fecha_inicio, :fecha_fin, :estado)";
$stmt = $conn->prepare($query);

$stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
$stmt->bindParam(':descripcion', $descripcion);
$stmt->bindParam(':fecha_inicio', $fecha_inicio);
$stmt->bindParam(':fecha_fin', $fecha_fin);
$stmt->bindParam(':estado', $estado);

if ($stmt->execute()) {
    // echo "Tratamiento asignado exitosamente.";
    header('Location: /DrOnline/src/views/medico/pacientes_resgistrados.php');
} else {
    echo "Error al asignar el tratamiento: " . implode(" - ", $stmt->errorInfo());
}
?>
