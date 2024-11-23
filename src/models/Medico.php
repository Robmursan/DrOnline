<?php
class Medico {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear un médico en la base de datos
    public function crearMedico($id_usuario, $especialidad, $numero_colegiado, $telefono) {
        $query = "INSERT INTO medicos (id_usuario, especialidad, numero_colegiado, telefono) 
                  VALUES (:id_usuario, :especialidad, :numero_colegiado, :telefono)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_usuario", $id_usuario);
        $stmt->bindParam(":especialidad", $especialidad);
        $stmt->bindParam(":numero_colegiado", $numero_colegiado);
        $stmt->bindParam(":telefono", $telefono);
        return $stmt->execute();
    }

    // Método para obtener el ID del médico en base al ID del usuario
    public function obtenerIdMedico($id_usuario) {
        $query = "SELECT id_medico FROM medicos WHERE id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_usuario", $id_usuario);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id_medico'] : null;
    }
}
?>

