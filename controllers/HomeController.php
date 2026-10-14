<?php
// controllers/HomeController.php
// Parte pública del marketplace: portada con todas las publicaciones y detalle de cada una

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/GatoModel.php';

class HomeController extends Controller {

    public function home() {
        $filtros = [
            'q'          => trim($_GET['q'] ?? ''),
            'sexo'       => $_GET['sexo'] ?? '',
            'precio_min' => trim($_GET['precio_min'] ?? ''),
            'precio_max' => trim($_GET['precio_max'] ?? ''),
            'orden'      => $_GET['orden'] ?? 'recientes',
        ];

        $this->render('home', [
            'tituloPagina' => 'Marketplace de gatos fieros',
            'gatos' => GatoModel::buscar($filtros),
            'filtros' => $filtros,
            'hayFiltros' => $filtros['q'] !== '' || $filtros['sexo'] !== '' || $filtros['precio_min'] !== '' || $filtros['precio_max'] !== '',
        ]);
    }

    public function publicacion() {
        $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
        $gato = $id ? GatoModel::obtenerPorId($id) : null;

        if (!$gato) {
            self::flash('danger', 'Esa publicación no existe o fue eliminada.');
            $this->redirigir();
        }

        $this->render('publicacion', [
            'tituloPagina' => $gato['nombre'] . ' - Marketplace de gatos fieros',
            'gato' => $gato,
            'esDuenio' => $this->usuarioId() === (int) $gato['usuario_id'],
        ]);
    }
}
