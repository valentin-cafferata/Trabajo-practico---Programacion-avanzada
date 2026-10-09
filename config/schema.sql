CREATE DATABASE IF NOT EXISTS `tp_pa` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `tp_pa`;

CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `nombre` VARCHAR(100) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `productos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(100) NOT NULL,
    `descripcion` TEXT NULL,
    `precio` DECIMAL(10, 2) NOT NULL,
    `stock` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuarios` (`usuario`, `password`, `nombre`) 
VALUES 
    ('admin', 'admin123', 'Administrador Principal');

INSERT INTO `productos` (`nombre`, `descripcion`, `precio`, `stock`) 
VALUES 
    ('Teclado Mecánico RGB', 'Teclado gaming con switches rojos', 45000.00, 15), 
    ('Mouse Inalámbrico', 'Mouse ergonómico óptico 1600 DPI', 22000.50, 30), 
    ('Monitor 24" Full HD', 'Monitor IPS 75Hz HDMI', 185000.00, 8);