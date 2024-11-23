create database DrOnline03;

use DrOnline03;
drop database DrOnline03;

CREATE TABLE `citas` (
  `id_cita` INT(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` INT(11) NOT NULL,
  `fecha` DATE NOT NULL,
  `hora` TIME NOT NULL,
  `descripcion` TEXT DEFAULT NULL,
  PRIMARY KEY (`id_cita`),
  FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `medicos` (
  `id_medico` INT(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(11) DEFAULT NULL,
  `especialidad` VARCHAR(100) DEFAULT NULL,
  `numero_colegiado` VARCHAR(50) DEFAULT NULL,
  `telefono` VARCHAR(15) DEFAULT NULL,
  PRIMARY KEY (`id_medico`),
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pacientes` (
  `id_paciente` INT(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(11) DEFAULT NULL,
  `id_medico` INT(11) NOT NULL,
  `fecha_nacimiento` DATE DEFAULT NULL,
  `sexo` ENUM('M','F') DEFAULT NULL,
  `direccion` VARCHAR(255) DEFAULT NULL,
  `telefono` VARCHAR(15) DEFAULT NULL,
  PRIMARY KEY (`id_paciente`),
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL,
  FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`id_medico`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `registros_medicos` (
  `id_registro` INT(11) NOT NULL AUTO_INCREMENT,
  `id_paciente` INT(11) NOT NULL,
  `tension_arterial` VARCHAR(20) DEFAULT NULL,
  `glicemia` FLOAT DEFAULT NULL,
  `sintomas` TEXT DEFAULT NULL,
  `descripcion` TEXT DEFAULT NULL,
  `fecha_registro` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_registro`),
  FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tratamientos` (
  `id_tratamiento` INT(11) NOT NULL AUTO_INCREMENT,
  `id_medico` INT(11) DEFAULT NULL,
  `id_paciente` INT(11) DEFAULT NULL,
  `fecha_inicio` DATE DEFAULT NULL,
  `fecha_fin` DATE DEFAULT NULL,
  `descripcion` TEXT DEFAULT NULL,
  `estado` ENUM('activo','completado','cancelado') DEFAULT NULL,
  PRIMARY KEY (`id_tratamiento`),
  FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`id_medico`) ON DELETE SET NULL,
  FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `usuarios` (
  `id_usuario` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) DEFAULT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `contraseña` VARCHAR(255) DEFAULT NULL,
  `tipo_usuario` ENUM('medico','paciente') DEFAULT NULL,
  `fecha_creacion` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `ultima_actualizacion` TIMESTAMP NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
