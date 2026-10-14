<?php

class DatabaseException extends Exception {}

function getEnvConfig() {
    static $env = null;
    if ($env === null) {
        $envPath = __DIR__ . '/../.env';
        $env = file_exists($envPath) ? parse_ini_file($envPath) : [];
    }
    return $env;
}

function getDBConnection() {
    static $mysqli = null;
    if ($mysqli !== null) {
        return $mysqli;
    }

    $env = getEnvConfig();

    $host   = $env['DB_HOST'] ?? '127.0.0.1';
    $user   = $env['DB_USER'] ?? 'root';
    $pass   = $env['DB_PASS'] ?? '';
    $dbname = $env['DB_NAME'] ?? 'tp_pa';
    $port   = (int) ($env['DB_PORT'] ?? 3306);

    // Cualquier error de mysqli se lanza como excepción para poder manejarlo
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $mysqli = new mysqli($host, $user, $pass, $dbname, $port);
        $mysqli->set_charset('utf8mb4');
    } catch (mysqli_sql_exception $e) {
        $mysqli = null;
        error_log('Error de conexión a la BD: ' . $e->getMessage());
        throw new DatabaseException('No se pudo conectar a la base de datos.', 0, $e);
    }

    return $mysqli;
}
