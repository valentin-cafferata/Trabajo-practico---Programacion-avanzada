<?php
// controllers/index.php

require_once __DIR__ . '/AuthController.php';
// Aquí después requerirás los demás controladores (ej: ProductController.php)

// Detectar la acción enviada por GET o POST
$action = $_REQUEST['action'] ?? '';

$authController = new AuthController(); 
switch ($action) { 
    case 'login': 
        $authController->login(); 
        break;
   
    case 'logout': 
        $authController->logout(); 
        break;

    default: // Si no hay acción válida, redirige al login 
        header('Location: ../views/login.php'); 
        exit();
}