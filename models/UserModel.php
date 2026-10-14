<?php
// models/UserModel.php

require_once __DIR__ . '/../config/database.php';

class UserModel {

    // Devuelve el usuario como array asociativo, o null si no existe
    public static function obtenerPorUsuario($usuario) {
        $db = getDBConnection();

        // Consulta preparada para evitar Inyección SQL
        $stmt = $db->prepare('SELECT id, usuario, password, nombre FROM usuarios WHERE usuario = ? LIMIT 1');
        $stmt->bind_param('s', $usuario);
        $stmt->execute();

        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $user;
    }

    // Devuelve el usuario solo si existe y la contraseña coincide con el hash guardado
    public static function autenticar($usuario, $password) {
        $user = self::obtenerPorUsuario($usuario);

        if (!$user || !password_verify($password, $user['password'])) {
            return null;
        }

        return $user;
    }

    // Da de alta un usuario nuevo y devuelve su id
    public static function crear($usuario, $nombre, $password) {
        $db = getDBConnection();
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare('INSERT INTO usuarios (usuario, nombre, password) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $usuario, $nombre, $hash);
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();

        return $id;
    }

    // Normaliza los datos del formulario de registro y devuelve [datos, errores]
    public static function validarRegistro(array $entrada) {
        $datos = [
            'usuario'   => trim($entrada['usuario'] ?? ''),
            'nombre'    => trim($entrada['nombre'] ?? ''),
            'password'  => $entrada['password'] ?? '',
            'password2' => $entrada['password2'] ?? '',
        ];
        $errores = [];

        if (!preg_match('/^[A-Za-z0-9._-]{3,50}$/', $datos['usuario'])) {
            $errores['usuario'] = 'El usuario debe tener entre 3 y 50 caracteres (letras, números, punto, guion o guion bajo).';
        } elseif (self::obtenerPorUsuario($datos['usuario'])) {
            $errores['usuario'] = 'Ese nombre de usuario ya está en uso.';
        }
        if ($datos['nombre'] === '' || mb_strlen($datos['nombre']) > 100) {
            $errores['nombre'] = 'Ingresá tu nombre (máximo 100 caracteres).';
        }
        if (strlen($datos['password']) < 6) {
            $errores['password'] = 'La contraseña debe tener al menos 6 caracteres.';
        }
        if ($datos['password'] !== $datos['password2']) {
            $errores['password2'] = 'Las contraseñas no coinciden.';
        }

        return [$datos, $errores];
    }
}
