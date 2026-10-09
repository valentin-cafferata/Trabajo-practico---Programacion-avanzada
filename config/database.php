<?php

function getDBConnection() {
    // 1. Cargar configuración desde el archivo .env
    $envPath = __DIR__ . '/../.env';
    $env = file_exists($envPath) ? parse_ini_file($envPath) : [];

    $host     = $env['DB_HOST']     ?? '127.0.0.1';
    $user     = $env['DB_USER']     ?? 'root';
    $pass     = $env['DB_PASS']     ?? '';
    $dbname   = $env['DB_NAME']     ?? 'tp_pa';
    $port     = $env['DB_PORT']     ?? 3306;

    // 2. Desactivar reporte de errores automáticos de mysqli para manejar la excepción nosotros
    mysqli_report(MYSQLI_REPORT_OFF);

    // 3. Crear la conexión con la clase mysqli (Clase 6)
    $mysqli = @new mysqli($host, $user, $pass, $dbname, $port);

    // 4. Validar si la conexión falló (Requerimiento del TP)
    if ($mysqli->connect_errno) {
        throw new Exception('No se pudo conectar a la base de datos.');
    } 
    
    // Configurar cotejo UTF-8
    $mysqli->set_charset("utf8mb4");
    return $mysqli; 
}

