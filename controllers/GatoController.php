<?php
// controllers/GatoController.php
// ABM (Alta, Baja y Modificación) de las publicaciones de gatos.
// Cada usuario solo puede administrar las publicaciones que cargó él.

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/GatoModel.php';
require_once __DIR__ . '/../helpers/Foto.php';

class GatoController extends Controller {

    public function misPublicaciones() {
        $this->requiereLogin();
        $this->render('gatos/mis_publicaciones', [
            'tituloPagina' => 'Mis publicaciones',
            'gatos' => GatoModel::listarPorUsuario($this->usuarioId()),
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

        if (!Foto::enviada('foto')) {
            $errores['foto'] = 'Subí una foto del gato.';
        }
        if ($errores) {
            $this->mostrarFormulario(null, $datos, $errores);
            return;
        }

        [$foto, $errorFoto] = Foto::guardar('foto');
        if ($errorFoto) {
            $this->mostrarFormulario(null, $datos, ['foto' => $errorFoto]);
            return;
        }

        GatoModel::crear($datos, $this->usuarioId(), $foto);
        self::flash('success', "¡Listo! {$datos['nombre']} ya está publicado en el marketplace.");
        $this->redirigir('mis_publicaciones');
    }

    public function editar() {
        $this->requiereLogin();
        $gato = $this->buscarPropioOFallar($_GET['id'] ?? null);
        $this->mostrarFormulario($gato['id'], $gato);
    }

    public function actualizar() {
        $this->requiereLogin();
        $this->requierePost();
        $gato = $this->buscarPropioOFallar($_POST['id'] ?? null);

        [$datos, $errores] = GatoModel::validar($_POST);
        if ($errores) {
            $this->mostrarFormulario($gato['id'], $datos + ['foto' => $gato['foto']], $errores);
            return;
        }

        // La foto es opcional al editar: si no se sube una nueva, se conserva la actual
        [$foto, $errorFoto] = Foto::guardar('foto');
        if ($errorFoto) {
            $this->mostrarFormulario($gato['id'], $datos + ['foto' => $gato['foto']], ['foto' => $errorFoto]);
            return;
        }

        GatoModel::actualizar($gato['id'], $datos, $foto);
        if ($foto) {
            Foto::borrar($gato['foto']);
        }

        self::flash('success', "Se guardaron los cambios de {$datos['nombre']}.");
        $this->redirigir('mis_publicaciones');
    }

    public function eliminar() {
        $this->requiereLogin();
        $this->requierePost();
        $gato = $this->buscarPropioOFallar($_POST['id'] ?? null);

        GatoModel::eliminar($gato['id']);
        Foto::borrar($gato['foto']);

        self::flash('success', "Se eliminó la publicación de {$gato['nombre']}.");
        $this->redirigir('mis_publicaciones');
    }

    private function mostrarFormulario($id, array $gato, array $errores = []) {
        $this->render('gatos/formulario', [
            'tituloPagina' => $id ? 'Editar publicación' : 'Publicar un gato',
            'id' => $id,
            'gato' => $gato,
            'errores' => $errores,
            'sexos' => GatoModel::SEXOS,
        ]);
    }

    // Busca la publicación y verifica que pertenezca al usuario logueado
    private function buscarPropioOFallar($id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $gato = $id ? GatoModel::obtenerPorId($id) : null;

        if (!$gato) {
            self::flash('danger', 'Esa publicación no existe.');
            $this->redirigir('mis_publicaciones');
        }
        if ((int) $gato['usuario_id'] !== $this->usuarioId()) {
            self::flash('danger', 'Solo podés modificar tus propias publicaciones.');
            $this->redirigir('mis_publicaciones');
        }

        return $gato;
    }
}
