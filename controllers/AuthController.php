<?php
// controllers/AuthController.php
// Login, registro y logout

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/UserModel.php';

class AuthController extends Controller {

    public function mostrarLogin() {
        if ($this->usuarioId()) {
            $this->redirigir();
        }

        $this->render('login', [
            'tituloPagina' => 'Iniciar sesión',
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
        $_SESSION['usuario_previo'] = $usuario;

        if ($usuario === '' || $password === '') {
            $this->fallar('Completá el usuario y la contraseña.');
        }

        if (!$this->captchaValido($_POST['g-recaptcha-response'] ?? '')) {
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

        unset($_SESSION['usuario_previo']);
        $this->iniciarSesion($user);

        self::flash('success', '¡Hola, ' . $user['nombre'] . '! Ya podés publicar tus gatos.');
        $this->redirigir();
    }

    public function mostrarRegistro() {
        if ($this->usuarioId()) {
            $this->redirigir();
        }
        $this->render('registro', [
            'tituloPagina' => 'Crear cuenta',
            'datos' => [],
            'errores' => [],
        ]);
    }

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('registro');
        }

        [$datos, $errores] = UserModel::validarRegistro($_POST);

        if (!$this->captchaValido($_POST['g-recaptcha-response'] ?? '')) {
            $errores['captcha'] = 'Debes completar el captcha.';
        }

        if ($errores) {
            $this->render('registro', [
                'tituloPagina' => 'Crear cuenta',
                'datos' => $datos,
                'errores' => $errores,
            ]);
            return;
        }

        $id = UserModel::crear($datos['usuario'], $datos['nombre'], $datos['password']);
        $this->iniciarSesion(['id' => $id, 'usuario' => $datos['usuario'], 'nombre' => $datos['nombre']]);

        self::flash('success', '¡Bienvenido, ' . $datos['nombre'] . '! Tu cuenta fue creada. Ya podés publicar tu primer gato.');
        $this->redirigir('gato_nuevo');
    }

    public function logout() {
        session_unset();
        session_destroy();
        session_start();
        self::flash('info', 'Cerraste sesión correctamente.');
        $this->redirigir();
    }

    private function iniciarSesion(array $user) {
        session_regenerate_id(true);
        $_SESSION['usuario_id'] = (int) $user['id'];
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['nombre'] = $user['nombre'] ?: $user['usuario'];
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
            return false;
        }

        return !empty(json_decode($respuesta, true)['success']);
    }

    private function fallar($mensaje) {
        self::flash('danger', $mensaje);
        $this->redirigir('login');
    }
}
