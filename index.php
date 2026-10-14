<?php
// index.php
// Punto de entrada único (front controller): recibe ?accion=... y llama al controlador correspondiente

define('APP_INICIADA', true);

session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/GatoController.php';

$rutas = [
    ''                => [HomeController::class, 'home'],
    'inicio'          => [HomeController::class, 'inicio'],
    'login'           => [AuthController::class, 'mostrarLogin'],
    'autenticar'      => [AuthController::class, 'login'],
    'logout'          => [AuthController::class, 'logout'],
    'gatos'           => [GatoController::class, 'listar'],
    'gato_nuevo'      => [GatoController::class, 'nuevo'],
    'gato_guardar'    => [GatoController::class, 'guardar'],
    'gato_editar'     => [GatoController::class, 'editar'],
    'gato_actualizar' => [GatoController::class, 'actualizar'],
    'gato_eliminar'   => [GatoController::class, 'eliminar'],
];

$accion = $_GET['accion'] ?? '';
[$clase, $metodo] = $rutas[$accion] ?? $rutas[''];

try {
    (new $clase())->$metodo();
} catch (DatabaseException | mysqli_sql_exception $e) {
    error_log('Error de base de datos: ' . $e->getMessage());
    http_response_code(503);
    $tituloPagina = 'Error de conexión';
    $sinConexion = $e instanceof DatabaseException;
    require __DIR__ . '/views/error_bd.php';
}
