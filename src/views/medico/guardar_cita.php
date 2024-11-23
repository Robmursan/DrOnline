<?php
require_once '../../../config/database.php';

// Captura los datos enviados desde el formulario
$id_paciente = $_POST['id_paciente'] ?? null;
$fecha = $_POST['fecha'] ?? null;
$hora = $_POST['hora'] ?? null;
$descripcion = $_POST['descripcion'] ?? null;

// Verifica que todos los campos obligatorios estén presentes
if (!$id_paciente || !$fecha || !$hora) {
    echo "Error: Todos los campos obligatorios deben completarse.";
    exit;
}

try {
    // Consulta para insertar la cita en la base de datos
    $query = "INSERT INTO citas (id_paciente, fecha, hora, descripcion)
              VALUES (:id_paciente, :fecha, :hora, :descripcion)";
    $stmt = $conn->prepare($query);

    // Vincula los valores a los parámetros
    $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':hora', $hora);
    $stmt->bindParam(':descripcion', $descripcion);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        // echo "Cita asignada exitosamente.";
        header('Location: /DrOnline/src/views/medico/pacientes_resgistrados.php');
    } else {
        echo "Error al asignar la cita: " . implode(" - ", $stmt->errorInfo());
    }
} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
    exit;
}
?>
