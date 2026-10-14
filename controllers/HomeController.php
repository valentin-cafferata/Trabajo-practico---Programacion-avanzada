<?php
// controllers/HomeController.php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/GatoModel.php';

class HomeController extends Controller {

    public function home() {
        if (isset($_SESSION['usuario'])) {
            $this->redirigir('inicio');
        }
        $this->render('home', ['tituloPagina' => 'Home Público']);
    }

    public function inicio() {
        $this->requiereLogin();
        $this->render('inicio', [
            'tituloPagina' => 'Inicio Privado',
            'totalGatos' => GatoModel::contar(),
        ]);
    }
}
