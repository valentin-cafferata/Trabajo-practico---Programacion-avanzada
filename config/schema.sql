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
    `nombre` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Producto del ABM: las publicaciones de gatos del marketplace.
-- Cada publicación pertenece al usuario que la cargó.
CREATE TABLE `gatos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT NOT NULL,
    `nombre` VARCHAR(100) NOT NULL,
    `raza` VARCHAR(60) NOT NULL,
    `edad` TINYINT UNSIGNED NOT NULL,
    `sexo` ENUM('Macho', 'Hembra') NOT NULL,
    `precio` DECIMAL(10, 2) NOT NULL,
    `ubicacion` VARCHAR(100) NOT NULL,
    `descripcion` VARCHAR(1000) NULL,
    `foto` VARCHAR(255) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_gatos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Las contraseñas se guardan hasheadas con password_hash() de PHP (bcrypt).
-- fcytuader / programacionavanzada
-- admin     / admin123
-- lucas     / lucas123
INSERT INTO `usuarios` (`usuario`, `password`, `nombre`) VALUES
    ('fcytuader', '$2y$10$PxQTpuU5bLAm4QAODtE0sOMxCONLaF9.nN1i0zlrS7JHuaeyqUk0y', 'FCyT UADER'),
    ('admin', '$2y$10$j/qmC3DQ/qJ5oSrxYo56ceQbF7uOSS7YC7i/OyJdaG9YaTO/D.RiC', 'Administrador Principal'),
    ('lucas', '$2y$10$f2WRFWHTxj/ZtXdjCQaYK.nO.g2tO0T2h5Eq4jcKeXseLOgGlNCbu', 'Lucas Paz');

INSERT INTO `gatos` (`usuario_id`, `nombre`, `raza`, `edad`, `sexo`, `precio`, `ubicacion`, `descripcion`, `foto`) VALUES
    (1, 'Maxwell', 'Común europeo', 3, 'Macho', 150000.00, 'Concepción del Uruguay, Entre Ríos', 'Gira sobre sí mismo al ritmo de la música. Muy famoso en internet. Se entrega con su música favorita.', 'views/assets/img/gatos/maxwell.jpg'),
    (1, 'Michi', 'Siamés', 2, 'Hembra', 220000.00, 'Paraná, Entre Ríos', 'Ojos celestes y maullido potente. Domina el sillón y no lo comparte.', 'views/assets/img/gatos/michi.jpg'),
    (2, 'Garfield', 'Exótico de pelo corto', 5, 'Macho', 95000.50, 'Gualeguaychú, Entre Ríos', 'Odia los lunes y ama la lasaña. Ideal para una casa tranquila.', 'views/assets/img/gatos/garfield.jpg'),
    (2, 'Luna', 'Persa', 1, 'Hembra', 310000.00, 'Santa Fe, Santa Fe', 'Pelo largo y carácter tranquilo. Vacunas al día.', 'views/assets/img/gatos/luna.jpg'),
    (3, 'Tigre', 'Bengalí', 4, 'Macho', 450000.00, 'Rosario, Santa Fe', 'Fiero de verdad: trepa cortinas y caza moscas. Requiere dueño con experiencia.', 'views/assets/img/gatos/tigre.jpg'),
    (3, 'Pelusa', 'Angora turco', 2, 'Hembra', 180000.00, 'Colón, Entre Ríos', 'Suave como una nube. Le encantan las cajas de cartón.', 'views/assets/img/gatos/pelusa.jpg');
