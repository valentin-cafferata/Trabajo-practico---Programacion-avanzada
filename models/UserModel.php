<?php
// models/UserModel.php

require_once __DIR__ . '/../config/database.php';

class UserModel {

    // Validar si existe el usuario y coincide la contraseña
    public static function obtenerPorUsuario($usuario) {
        $db = getDBConnection();

        // Consulta preparada para evitar Inyección SQL
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE usuario = ? LIMIT 1");

        // Validar si la consulta falló para ver el error exacto de MySQL 
        if (!$stmt) { 
            die("Error en la consulta SQL: " . $db->error); 
        }

        $stmt->bind_param("s", $usuario);
        $stmt->execute();

        $resultado = $stmt->get_result(); 
        $user = $resultado->fetch_assoc();

        $stmt->close(); 
        $db->close(); 
        return $user; // Retorna el array del usuario o null si no existe 
    } 
}