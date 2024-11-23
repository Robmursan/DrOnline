<?php
class RegistroMedico {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear un registro médico
    public function crearRegistro($id_paciente, $tension_arterial, $glicemia, $sintomas, $descripcion) {
        $query = "INSERT INTO registros_medicos (id_paciente, tension_arterial, glicemia, sintomas, descripcion) 
                  VALUES (:id_paciente, :tension_arterial, :glicemia, :sintomas, :descripcion)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_paciente", $id_paciente, PDO::PARAM_INT);
        $stmt->bindParam(":tension_arterial", $tension_arterial);
        $stmt->bindParam(":glicemia", $glicemia);
        $stmt->bindParam(":sintomas", $sintomas);
        $stmt->bindParam(":descripcion", $descripcion);
        return $stmt->execute();
    }

    // Método para obtener los registros médicos de un paciente
    public function obtenerRegistrosPorPaciente($id_paciente) {
        $query = "SELECT * FROM registros_medicos WHERE id_paciente = :id_paciente ORDER BY fecha_registro DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_paciente", $id_paciente, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
