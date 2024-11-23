<?php
class Cita {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crearCita($id_paciente, $id_medico, $fecha, $motivo) {
        $query = "INSERT INTO citas (id_paciente, id_medico, fecha_cita, motivo) 
                  VALUES (:id_paciente, :id_medico, :fecha, :motivo)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_paciente", $id_paciente);
        $stmt->bindParam(":id_medico", $id_medico);
        $stmt->bindParam(":fecha", $fecha);
        $stmt->bindParam(":motivo", $motivo);
        return $stmt->execute();
    }
}
?>
