<?php
// controllers/GatoController.php
// ABM (Alta, Baja y Modificación) de gatos

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/GatoModel.php';

class GatoController extends Controller {

    public function listar() {
        $this->requiereLogin();
        $this->render('gatos/listado', [
            'tituloPagina' => 'Gatos',
            'gatos' => GatoModel::listar(),
        ]);
    }

    public function nuevo() {
        $this->requiereLogin();
        $this->mostrarFormulario(null, []);
    }

    public function guardar() {
        $this->requiereLogin();
        $this->requierePost();

        [$datos, $errores] = GatoModel::validar($_POST);
        if ($errores) {
            $this->mostrarFormulario(null, $datos, $errores);
            return;
        }

        $id = GatoModel::crear($datos);
        self::flash('success', "Se dio de alta a {$datos['nombre']} (ID {$id}).");
        $this->redirigir('gatos');
    }

    public function editar() {
        $this->requiereLogin();
        $gato = $this->buscarOFallar($_GET['id'] ?? null);
        $this->mostrarFormulario($gato['id'], $gato);
    }

    public function actualizar() {
        $this->requiereLogin();
        $this->requierePost();
        $gato = $this->buscarOFallar($_POST['id'] ?? null);

        [$datos, $errores] = GatoModel::validar($_POST);
        if ($errores) {
            $this->mostrarFormulario($gato['id'], $datos, $errores);
            return;
        }

        GatoModel::actualizar($gato['id'], $datos);
        self::flash('success', "Se modificaron los datos de {$datos['nombre']}.");
        $this->redirigir('gatos');
    }

    public function eliminar() {
        $this->requiereLogin();
        $this->requierePost();
        $gato = $this->buscarOFallar($_POST['id'] ?? null);

        GatoModel::eliminar($gato['id']);
        self::flash('success', "Se dio de baja a {$gato['nombre']}.");
        $this->redirigir('gatos');
    }

    private function mostrarFormulario($id, array $gato, array $errores = []) {
        $this->render('gatos/formulario', [
            'tituloPagina' => $id ? 'Editar gato' : 'Nuevo gato',
            'id' => $id,
            'gato' => $gato,
            'errores' => $errores,
            'sexos' => GatoModel::SEXOS,
        ]);
    }

    private function buscarOFallar($id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $gato = $id ? GatoModel::obtenerPorId($id) : null;

        if (!$gato) {
            self::flash('danger', 'El gato solicitado no existe.');
            $this->redirigir('gatos');
        }

        return $gato;
    }
}
