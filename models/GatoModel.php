<?php
// models/GatoModel.php

require_once __DIR__ . '/../config/database.php';

class GatoModel {

    const SEXOS = ['Macho', 'Hembra'];

    const ORDENES = [
        'recientes'   => 'g.created_at DESC',
        'precio_asc'  => 'g.precio ASC',
        'precio_desc' => 'g.precio DESC',
    ];

    const CAMPOS = 'g.id, g.usuario_id, g.nombre, g.raza, g.edad, g.sexo, g.precio, g.ubicacion, g.descripcion, g.foto,
                    g.created_at, u.nombre AS publicador, u.usuario AS publicador_usuario';

    // Publicaciones públicas del marketplace, con búsqueda y filtros
    public static function buscar(array $filtros) {
        $db = getDBConnection();

        $where = [];
        $tipos = '';
        $valores = [];

        if (!empty($filtros['q'])) {
            $like = '%' . $filtros['q'] . '%';
            $where[] = '(g.nombre LIKE ? OR g.raza LIKE ? OR g.descripcion LIKE ? OR g.ubicacion LIKE ?)';
            $tipos .= 'ssss';
            array_push($valores, $like, $like, $like, $like);
        }
        if (!empty($filtros['sexo']) && in_array($filtros['sexo'], self::SEXOS, true)) {
            $where[] = 'g.sexo = ?';
            $tipos .= 's';
            $valores[] = $filtros['sexo'];
        }
        if (isset($filtros['precio_min']) && is_numeric($filtros['precio_min'])) {
            $where[] = 'g.precio >= ?';
            $tipos .= 'd';
            $valores[] = (float) $filtros['precio_min'];
        }
        if (isset($filtros['precio_max']) && is_numeric($filtros['precio_max'])) {
            $where[] = 'g.precio <= ?';
            $tipos .= 'd';
            $valores[] = (float) $filtros['precio_max'];
        }

        $orden = self::ORDENES[$filtros['orden'] ?? ''] ?? self::ORDENES['recientes'];

        $sql = 'SELECT ' . self::CAMPOS . ' FROM gatos g JOIN usuarios u ON u.id = g.usuario_id'
             . ($where ? ' WHERE ' . implode(' AND ', $where) : '')
             . ' ORDER BY ' . $orden;

        $stmt = $db->prepare($sql);
        if ($valores) {
            $stmt->bind_param($tipos, ...$valores);
        }
        $stmt->execute();
        $gatos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $gatos;
    }

    // Publicaciones de un usuario (para su panel "Mis publicaciones")
    public static function listarPorUsuario($usuarioId) {
        $db = getDBConnection();
        $stmt = $db->prepare('SELECT ' . self::CAMPOS . ' FROM gatos g JOIN usuarios u ON u.id = g.usuario_id
                              WHERE g.usuario_id = ? ORDER BY g.created_at DESC');
        $stmt->bind_param('i', $usuarioId);
        $stmt->execute();
        $gatos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $gatos;
    }

    public static function contar() {
        $db = getDBConnection();
        return (int) $db->query('SELECT COUNT(*) FROM gatos')->fetch_row()[0];
    }

    public static function obtenerPorId($id) {
        $db = getDBConnection();
        $stmt = $db->prepare('SELECT ' . self::CAMPOS . ' FROM gatos g JOIN usuarios u ON u.id = g.usuario_id WHERE g.id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $gato = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $gato;
    }

    public static function crear(array $gato, $usuarioId, $foto) {
        $db = getDBConnection();
        $stmt = $db->prepare(
            'INSERT INTO gatos (usuario_id, nombre, raza, edad, sexo, precio, ubicacion, descripcion, foto)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->bind_param(
            'issisdsss',
            $usuarioId, $gato['nombre'], $gato['raza'], $gato['edad'], $gato['sexo'],
            $gato['precio'], $gato['ubicacion'], $gato['descripcion'], $foto
        );
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
        return $id;
    }

    // Si $foto es null se conserva la foto actual
    public static function actualizar($id, array $gato, $foto = null) {
        $db = getDBConnection();
        $stmt = $db->prepare(
            'UPDATE gatos SET nombre = ?, raza = ?, edad = ?, sexo = ?, precio = ?, ubicacion = ?, descripcion = ?,
                              foto = COALESCE(?, foto)
             WHERE id = ?'
        );
        $stmt->bind_param(
            'ssisdsssi',
            $gato['nombre'], $gato['raza'], $gato['edad'], $gato['sexo'],
            $gato['precio'], $gato['ubicacion'], $gato['descripcion'], $foto, $id
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
            'ubicacion'   => trim($entrada['ubicacion'] ?? ''),
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
        if ($datos['ubicacion'] === '' || mb_strlen($datos['ubicacion']) > 100) {
            $errores['ubicacion'] = 'La ubicación es obligatoria (máximo 100 caracteres).';
        }
        if (mb_strlen($datos['descripcion']) > 1000) {
            $errores['descripcion'] = 'La descripción admite hasta 1000 caracteres.';
        }

        if (!$errores) {
            $datos['edad'] = (int) $datos['edad'];
            $datos['precio'] = round((float) $datos['precio'], 2);
            $datos['descripcion'] = $datos['descripcion'] === '' ? null : $datos['descripcion'];
        }

        return [$datos, $errores];
    }
}
