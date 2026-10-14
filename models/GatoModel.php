<?php
// models/GatoModel.php

require_once __DIR__ . '/../config/database.php';

class GatoModel {

    const SEXOS = ['Macho', 'Hembra'];

    public static function listar() {
        $db = getDBConnection();
        $resultado = $db->query('SELECT id, nombre, raza, edad, sexo, precio, descripcion FROM gatos ORDER BY id');
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public static function contar() {
        $db = getDBConnection();
        return (int) $db->query('SELECT COUNT(*) FROM gatos')->fetch_row()[0];
    }

    public static function obtenerPorId($id) {
        $db = getDBConnection();
        $stmt = $db->prepare('SELECT id, nombre, raza, edad, sexo, precio, descripcion FROM gatos WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $gato = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $gato;
    }

    public static function crear(array $gato) {
        $db = getDBConnection();
        $stmt = $db->prepare(
            'INSERT INTO gatos (nombre, raza, edad, sexo, precio, descripcion) VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->bind_param(
            'ssisds',
            $gato['nombre'], $gato['raza'], $gato['edad'],
            $gato['sexo'], $gato['precio'], $gato['descripcion']
        );
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
        return $id;
    }

    public static function actualizar($id, array $gato) {
        $db = getDBConnection();
        $stmt = $db->prepare(
            'UPDATE gatos SET nombre = ?, raza = ?, edad = ?, sexo = ?, precio = ?, descripcion = ? WHERE id = ?'
        );
        $stmt->bind_param(
            'ssisdsi',
            $gato['nombre'], $gato['raza'], $gato['edad'],
            $gato['sexo'], $gato['precio'], $gato['descripcion'], $id
        );
        $stmt->execute();
        $stmt->close();
    }

    public static function eliminar($id) {
        $db = getDBConnection();
        $stmt = $db->prepare('DELETE FROM gatos WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $filas = $stmt->affected_rows;
        $stmt->close();
        return $filas > 0;
    }

    // Normaliza los datos del formulario y devuelve [datos, errores]
    public static function validar(array $entrada) {
        $datos = [
            'nombre'      => trim($entrada['nombre'] ?? ''),
            'raza'        => trim($entrada['raza'] ?? ''),
            'edad'        => trim($entrada['edad'] ?? ''),
            'sexo'        => $entrada['sexo'] ?? '',
            'precio'      => str_replace(',', '.', trim($entrada['precio'] ?? '')),
            'descripcion' => trim($entrada['descripcion'] ?? ''),
        ];
        $errores = [];

        if ($datos['nombre'] === '' || mb_strlen($datos['nombre']) > 100) {
            $errores['nombre'] = 'El nombre es obligatorio (máximo 100 caracteres).';
        }
        if ($datos['raza'] === '' || mb_strlen($datos['raza']) > 60) {
            $errores['raza'] = 'La raza es obligatoria (máximo 60 caracteres).';
        }
        if (filter_var($datos['edad'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 30]]) === false) {
            $errores['edad'] = 'La edad debe ser un número entero entre 0 y 30.';
        }
        if (!in_array($datos['sexo'], self::SEXOS, true)) {
            $errores['sexo'] = 'Seleccioná el sexo.';
        }
        if (!is_numeric($datos['precio']) || $datos['precio'] < 0 || $datos['precio'] > 99999999.99) {
            $errores['precio'] = 'El precio debe ser un número mayor o igual a 0.';
        }
        if (mb_strlen($datos['descripcion']) > 500) {
            $errores['descripcion'] = 'La descripción admite hasta 500 caracteres.';
        }

        if (!$errores) {
            $datos['edad'] = (int) $datos['edad'];
            $datos['precio'] = round((float) $datos['precio'], 2);
            $datos['descripcion'] = $datos['descripcion'] === '' ? null : $datos['descripcion'];
        }

        return [$datos, $errores];
    }
}
