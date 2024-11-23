<?php
class Paciente {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para registrar un usuario y un paciente al mismo tiempo
    public function registrarUsuarioYPaciente($nombre, $email, $password, $tipo_usuario, $id_medico, $fecha_nacimiento, $sexo, $direccion, $telefono) {
        try {
            // Verifica si el correo electrónico ya está en uso solo para el tipo de usuario "paciente"
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

            // Inicia una transacción para asegurar que ambas inserciones sean exitosas
            $this->conn->beginTransaction();

            // Inserta el usuario en la tabla "usuarios"
            $queryUsuario = "INSERT INTO usuarios (nombre, email, contraseña, tipo_usuario) 
                             VALUES (:nombre, :email, :password, :tipo_usuario)";
            $stmtUsuario = $this->conn->prepare($queryUsuario);

            // Vincula los parámetros para la tabla "usuarios"
            $stmtUsuario->bindParam(":nombre", $nombre);
            $stmtUsuario->bindParam(":email", $email);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmtUsuario->bindParam(":password", $hashed_password);
            $stmtUsuario->bindParam(":tipo_usuario", $tipo_usuario);

            // Ejecuta la inserción en la tabla "usuarios"
            if (!$stmtUsuario->execute()) {
                $this->conn->rollBack();
                echo "Error al insertar en usuarios: " . implode(" - ", $stmtUsuario->errorInfo());
                return false;
            }

            // Obtiene el ID del usuario recién insertado
            $id_usuario = $this->conn->lastInsertId();

            // Inserta el paciente en la tabla "pacientes"
            $queryPaciente = "INSERT INTO pacientes (id_medico, id_usuario, fecha_nacimiento, sexo, direccion, telefono) 
                              VALUES (:id_medico, :id_usuario, :fecha_nacimiento, :sexo, :direccion, :telefono)";
            $stmtPaciente = $this->conn->prepare($queryPaciente);

            // Vincula los parámetros para la tabla "pacientes"
            $stmtPaciente->bindParam(":id_medico", $id_medico);
            $stmtPaciente->bindParam(":id_usuario", $id_usuario); // ID del usuario recién insertado
            $stmtPaciente->bindParam(":fecha_nacimiento", $fecha_nacimiento);
            $stmtPaciente->bindParam(":sexo", $sexo);
            $stmtPaciente->bindParam(":direccion", $direccion);
            $stmtPaciente->bindParam(":telefono", $telefono);

            // Ejecuta la inserción en la tabla "pacientes"
            if ($stmtPaciente->execute()) {
                // Confirma la transacción si ambas inserciones fueron exitosas
                $this->conn->commit();
                return $this->conn->lastInsertId();
            } else {
                // Si falla la inserción en "pacientes", deshace la transacción
                $this->conn->rollBack();
                echo "Error al insertar en pacientes: " . implode(" - ", $stmtPaciente->errorInfo());
                return false;
            }
        } catch (Exception $e) {
            // Si ocurre una excepción, deshace la transacción y muestra el mensaje de error
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
        $query = "SELECT * FROM pacientes WHERE id_paciente = :id_paciente";
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
        $query = "DELETE FROM pacientes WHERE id_paciente = :id_paciente";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
