<?php
// controllers/AuthController.php

require_once __DIR__ . '/../models/UserModel.php';

class AuthController {

    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 1. Validar que la petición sea POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ../views/login.php');
            exit();
        }

        $usuario  = trim($_POST['usuario'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $captcha  = $_POST['g-recaptcha-response'] ?? '';

        // 2. Validar Captcha presente
        if (empty($captcha)) {
            header('Location: ../views/login.php?captcha_error=1');
            exit();
        }

        // 3. Cargar variables de entorno
        $env = parse_ini_file(__DIR__ . '/../.env');
        $secret = $env['RECAPTCHA_SECRET'] ?? '';

        // 4. Verificar captcha con Google
        $response = file_get_contents(
            'https://www.google.com/recaptcha/api/siteverify?secret=' .
            urlencode($secret) . '&response=' . urlencode($captcha)
        );
        $resultadoCaptcha = json_decode($response, true);

        if (empty($resultadoCaptcha['success'])) {
            header('Location: ../views/login.php?captcha_error=1');
            exit();
        }

        // 5. Verificar usuario y contraseña en la Base de Datos 
        $user = UserModel::obtenerPorUsuario($usuario); 
        
        // Si no existe el usuario o la contraseña no coincide 
        if (!$user || $user['password'] !== $password) { 
            header('Location: ../views/login.php?error=1'); 
            exit(); 
        } 
        // 6. Login correcto: guardar en sesión y redirigir 
        $_SESSION['usuario'] = $user['usuario']; 
        header('Location: ../views/inicio.php?login=success'); 
        exit();
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();

        header('Location: ../views/login.php');
        exit();
    }
}