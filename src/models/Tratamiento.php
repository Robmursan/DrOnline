<?php
class Tratamiento {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todos los tratamientos para un médico específico
    public function obtenerTratamientosPorMedico($id_medico) {
        $query = "SELECT * FROM tratamientos WHERE id_medico = :id_medico";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_medico', $id_medico, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo tratamiento
    public function crearTratamiento($id_medico, $id_paciente, $descripcion, $fecha_inicio, $fecha_fin, $estado) {
        $query = "INSERT INTO tratamientos (id_medico, id_paciente, descripcion, fecha_inicio, fecha_fin, estado)
                  VALUES (:id_medico, :id_paciente, :descripcion, :fecha_inicio, :fecha_fin, :estado)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_medico', $id_medico);
        $stmt->bindParam(':id_paciente', $id_paciente);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    // Obtener un tratamiento específico por ID
    public function obtenerTratamientoPorId($id_tratamiento) {
        $query = "SELECT * FROM tratamientos WHERE id_tratamiento = :id_tratamiento";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_tratamiento', $id_tratamiento, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar un tratamiento existente
    public function actualizarTratamiento($id_tratamiento, $descripcion, $fecha_inicio, $fecha_fin, $estado) {
        $query = "UPDATE tratamientos SET descripcion = :descripcion, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin, estado = :estado
                  WHERE id_tratamiento = :id_tratamiento";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_tratamiento', $id_tratamiento, PDO::PARAM_INT);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    // Eliminar un tratamiento
    public function eliminarTratamiento($id_tratamiento) {
        $query = "DELETE FROM tratamientos WHERE id_tratamiento = :id_tratamiento";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_tratamiento', $id_tratamiento, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
