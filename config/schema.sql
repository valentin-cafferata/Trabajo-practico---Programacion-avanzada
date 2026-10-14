-- Base de datos del TP: Marketplace de gatos fieros
-- Importar desde phpMyAdmin (pestaña Importar) o con:
--   C:\xampp\mysql\bin\mysql.exe -u root < config\schema.sql

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `tp_pa`;
CREATE DATABASE `tp_pa` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `tp_pa`;

CREATE TABLE `usuarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `nombre` VARCHAR(100) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Producto del ABM: los gatos que se publican en el marketplace
CREATE TABLE `gatos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(100) NOT NULL,
    `raza` VARCHAR(60) NOT NULL,
    `edad` TINYINT UNSIGNED NOT NULL,
    `sexo` ENUM('Macho', 'Hembra') NOT NULL,
    `precio` DECIMAL(10, 2) NOT NULL,
    `descripcion` VARCHAR(500) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Las contraseñas se guardan hasheadas con password_hash() de PHP (bcrypt).
-- fcytuader / programacionavanzada
-- admin     / admin123
INSERT INTO `usuarios` (`usuario`, `password`, `nombre`) VALUES
    ('fcytuader', '$2y$10$PxQTpuU5bLAm4QAODtE0sOMxCONLaF9.nN1i0zlrS7JHuaeyqUk0y', 'FCyT UADER'),
    ('admin', '$2y$10$j/qmC3DQ/qJ5oSrxYo56ceQbF7uOSS7YC7i/OyJdaG9YaTO/D.RiC', 'Administrador Principal');

INSERT INTO `gatos` (`nombre`, `raza`, `edad`, `sexo`, `precio`, `descripcion`) VALUES
    ('Maxwell', 'Común europeo', 3, 'Macho', 150000.00, 'Gira sobre sí mismo al ritmo de la música. Muy famoso.'),
    ('Michi', 'Siamés', 2, 'Hembra', 220000.00, 'Ojos celestes y maullido potente. Domina el sillón.'),
    ('Garfield', 'Exótico de pelo corto', 5, 'Macho', 95000.50, 'Odia los lunes y ama la lasaña.'),
    ('Luna', 'Persa', 1, 'Hembra', 310000.00, 'Pelo largo y carácter tranquilo.'),
    ('Tigre', 'Bengalí', 4, 'Macho', 450000.00, 'Fiero de verdad: trepa cortinas y caza moscas.');
