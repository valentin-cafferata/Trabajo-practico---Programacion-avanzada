<?php
// controllers/Controller.php

class Controller {

    // Renderiza una vista de la carpeta views/ pasándole las variables de $datos
    protected function render($vista, array $datos = []) {
        extract($datos);
        $flash = self::tomarFlash();
        require __DIR__ . '/../views/' . $vista . '.php';
    }

    protected function redirigir($accion = '', array $params = []) {
        $query = $accion !== '' ? array_merge(['accion' => $accion], $params) : $params;
        header('Location: index.php' . ($query ? '?' . http_build_query($query) : ''));
        exit();
    }

    protected function requiereLogin() {
        if (!isset($_SESSION['usuario'])) {
            self::flash('warning', 'Tenés que iniciar sesión para acceder a esa sección.');
            $this->redirigir('login');
        }
    }

    protected function requierePost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir();
        }
        if (!hash_equals(self::tokenCsrf(), $_POST['csrf'] ?? '')) {
            self::flash('danger', 'La sesión del formulario expiró. Volvé a intentarlo.');
            $this->redirigir();
        }
    }

    public static function flash($tipo, $mensaje) {
        $_SESSION['flash'] = ['tipo' => $tipo, 'mensaje' => $mensaje];
    }

    public static function tomarFlash() {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }

    public static function tokenCsrf() {
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf'];
    }
}
