<?php
class Paciente {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para registrar un usuario y un paciente al mismo tiempo
    public function registrarUsuarioYPaciente($nombre, $email, $password, $tipo_usuario, $id_medico, $fecha_nacimiento, $sexo, $direccion, $telefono) {
        try {
            $queryCheckEmail = "SELECT COUNT(*) FROM usuarios WHERE email = :email AND tipo_usuario = :tipo_usuario";
            $stmtCheckEmail = $this->conn->prepare($queryCheckEmail);
            $stmtCheckEmail->bindParam(":email", $email);
            $stmtCheckEmail->bindParam(":tipo_usuario", $tipo_usuario);
            $stmtCheckEmail->execute();
            $emailExists = $stmtCheckEmail->fetchColumn();

            if ($emailExists > 0) {
                echo "El correo electrónico ya está en uso. Por favor, utiliza otro correo electrónico.";
                return false;
            }

            $this->conn->beginTransaction();

            $queryUsuario = "INSERT INTO usuarios (nombre, email, contraseña, tipo_usuario) 
                             VALUES (:nombre, :email, :password, :tipo_usuario)";
            $stmtUsuario = $this->conn->prepare($queryUsuario);

            $stmtUsuario->bindParam(":nombre", $nombre);
            $stmtUsuario->bindParam(":email", $email);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmtUsuario->bindParam(":password", $hashed_password);
            $stmtUsuario->bindParam(":tipo_usuario", $tipo_usuario);

            if (!$stmtUsuario->execute()) {
                $this->conn->rollBack();
                echo "Error al insertar en usuarios: " . implode(" - ", $stmtUsuario->errorInfo());
                return false;
            }

            $id_usuario = $this->conn->lastInsertId();

            $queryPaciente = "INSERT INTO pacientes (id_medico, id_usuario, fecha_nacimiento, sexo, direccion, telefono) 
                              VALUES (:id_medico, :id_usuario, :fecha_nacimiento, :sexo, :direccion, :telefono)";
            $stmtPaciente = $this->conn->prepare($queryPaciente);

            $stmtPaciente->bindParam(":id_medico", $id_medico);
            $stmtPaciente->bindParam(":id_usuario", $id_usuario);
            $stmtPaciente->bindParam(":fecha_nacimiento", $fecha_nacimiento);
            $stmtPaciente->bindParam(":sexo", $sexo);
            $stmtPaciente->bindParam(":direccion", $direccion);
            $stmtPaciente->bindParam(":telefono", $telefono);

            if ($stmtPaciente->execute()) {
                $this->conn->commit();
                return $this->conn->lastInsertId();
            } else {
                $this->conn->rollBack();
                echo "Error al insertar en pacientes: " . implode(" - ", $stmtPaciente->errorInfo());
                return false;
            }
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Error al registrar el paciente: " . $e->getMessage();
            return false;
        }
    }

    // Método para obtener todos los pacientes de un médico específico
    public function obtenerPacientesPorMedico($id_medico) {
        $query = "SELECT p.id_paciente, p.fecha_nacimiento, p.sexo, p.direccion, p.telefono, u.nombre AS nombre_paciente, u.email AS email_paciente
                  FROM pacientes p
                  JOIN usuarios u ON p.id_usuario = u.id_usuario
                  WHERE p.id_medico = :id_medico";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_medico', $id_medico, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener los detalles de un paciente específico por su ID
    public function obtenerPacientePorId($id_paciente) {
        $query = "SELECT p.id_paciente, p.fecha_nacimiento, p.sexo, p.direccion, p.telefono, 
                         u.nombre AS nombre_paciente, u.email AS email_paciente
                  FROM pacientes p
                  JOIN usuarios u ON p.id_usuario = u.id_usuario
                  WHERE p.id_paciente = :id_paciente";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para actualizar los datos de un paciente
    public function actualizarPaciente($id_paciente, $nombre, $email, $fecha_nacimiento, $sexo, $direccion, $telefono) {
        $query = "UPDATE pacientes p
                  JOIN usuarios u ON p.id_usuario = u.id_usuario
                  SET u.nombre = :nombre, u.email = :email, p.fecha_nacimiento = :fecha_nacimiento, 
                      p.sexo = :sexo, p.direccion = :direccion, p.telefono = :telefono
                  WHERE p.id_paciente = :id_paciente";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        return $stmt->execute();
    }

    // Método para eliminar un paciente
    public function eliminarPaciente($id_paciente) {
        try {
            // Iniciar una transacción
            $this->conn->beginTransaction();
    
            // Eliminar tratamientos relacionados
            $queryTratamientos = "DELETE FROM tratamientos WHERE id_paciente = :id_paciente";
            $stmtTratamientos = $this->conn->prepare($queryTratamientos);
            $stmtTratamientos->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
            $stmtTratamientos->execute();
    
            // Eliminar el paciente
            $queryPaciente = "DELETE FROM pacientes WHERE id_paciente = :id_paciente";
            $stmtPaciente = $this->conn->prepare($queryPaciente);
            $stmtPaciente->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
            $stmtPaciente->execute();
    
            // Confirmar la transacción
            $this->conn->commit();
    
            return true;
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $this->conn->rollBack();
            echo "Error al eliminar el paciente: " . $e->getMessage();
            return false;
        }
    }

    // METODO PARA OBTENER PACIENTES CON SUS TRATAMIENTO    
    public function obtenerPacientesConRegistrosYTratamientos($id_medico) {
    $query = "SELECT 
                  p.id_paciente,
                  p.direccion,
                  p.telefono,
                  u.nombre AS nombre_paciente,
                  u.email AS email_paciente,
                  rm.tension_arterial,
                  rm.glicemia,
                  rm.sintomas,
                  rm.descripcion AS descripcion_registro,
                  t.descripcion AS descripcion_tratamiento,
                  t.estado
              FROM pacientes p
              JOIN usuarios u ON p.id_usuario = u.id_usuario
              LEFT JOIN registros_medicos rm ON p.id_paciente = rm.id_paciente
              LEFT JOIN tratamientos t ON p.id_paciente = t.id_paciente
              WHERE p.id_medico = :id_medico
              GROUP BY p.id_paciente";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id_medico', $id_medico, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    
}
?>
