<?php
// controllers/AuthController.php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/UserModel.php';

class AuthController extends Controller {

    public function mostrarLogin() {
        if (isset($_SESSION['usuario'])) {
            $this->redirigir('inicio');
        }

        $this->render('login', [
            'tituloPagina' => 'Login',
            'usuarioPrevio' => $_SESSION['usuario_previo'] ?? '',
        ]);
        unset($_SESSION['usuario_previo']);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('login');
        }

        $usuario  = trim($_POST['usuario'] ?? '');
        $password = $_POST['password'] ?? '';
        $captcha  = $_POST['g-recaptcha-response'] ?? '';
        $_SESSION['usuario_previo'] = $usuario;

        if ($usuario === '' || $password === '') {
            $this->fallar('Completá el usuario y la contraseña.');
        }

        if (!$this->captchaValido($captcha)) {
            $this->fallar('Debes completar el captcha.');
        }

        try {
            $user = UserModel::autenticar($usuario, $password);
        } catch (DatabaseException $e) {
            $this->fallar('No pudimos conectarnos con la base de datos. Intentá de nuevo en unos minutos.');
        }

        if (!$user) {
            $this->fallar('Usuario o contraseña incorrectos.');
        }

        session_regenerate_id(true);
        unset($_SESSION['usuario_previo']);
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['nombre'] = $user['nombre'] ?: $user['usuario'];

        self::flash('success', '¡Bienvenido, ' . $_SESSION['nombre'] . '!');
        $this->redirigir('inicio');
    }

    public function logout() {
        session_unset();
        session_destroy();
        session_start();
        self::flash('info', 'Cerraste sesión correctamente.');
        $this->redirigir('login');
    }

    private function captchaValido($captcha) {
        if ($captcha === '') {
            return false;
        }

        $secret = getEnvConfig()['RECAPTCHA_SECRET'] ?? '';
        $respuesta = @file_get_contents(
            'https://www.google.com/recaptcha/api/siteverify?secret=' .
            urlencode($secret) . '&response=' . urlencode($captcha)
        );

        if ($respuesta === false) {
            $this->fallar('No se pudo verificar el captcha. Revisá tu conexión a internet.');
        }

        return !empty(json_decode($respuesta, true)['success']);
    }

    private function fallar($mensaje) {
        self::flash('danger', $mensaje);
        $this->redirigir('login');
    }
}
