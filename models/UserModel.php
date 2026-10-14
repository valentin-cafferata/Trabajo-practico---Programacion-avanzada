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
}
