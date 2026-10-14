<?php
$scriptsExtra = ['views/assets/js/gato-form.js'];
require __DIR__ . '/../includes/header.php';

$valor = fn($campo) => htmlspecialchars((string) ($gato[$campo] ?? ''));
$claseError = fn($campo) => isset($errores[$campo]) ? 'is-invalid' : '';
?>

  <div class="container py-4 d-flex justify-content-center">
    <div class="bg-white p-4 rounded-4 shadow" style="max-width: 640px; width: 100%;">
      <h2 class="fw-bold mb-4"><?php echo $id ? 'Editar gato' : 'Nuevo gato'; ?></h2>

      <?php if ($errores): ?>
        <div class="alert alert-danger">Revisá los campos marcados en rojo.</div>
      <?php endif; ?>

      <form id="form-gato" action="index.php?accion=<?php echo $id ? 'gato_actualizar' : 'gato_guardar'; ?>" method="POST" novalidate>
        <input type="hidden" name="csrf" value="<?php echo Controller::tokenCsrf(); ?>">
        <?php if ($id): ?>
          <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php endif; ?>

        <div class="row g-3">
          <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre *</label>
            <input type="text" class="form-control <?php echo $claseError('nombre'); ?>" id="nombre" name="nombre"
                   maxlength="100" required value="<?php echo $valor('nombre'); ?>">
            <div class="invalid-feedback"><?php echo $errores['nombre'] ?? 'El nombre es obligatorio.'; ?></div>
          </div>

          <div class="col-md-6">
            <label for="raza" class="form-label">Raza *</label>
            <input type="text" class="form-control <?php echo $claseError('raza'); ?>" id="raza" name="raza"
                   maxlength="60" required value="<?php echo $valor('raza'); ?>">
            <div class="invalid-feedback"><?php echo $errores['raza'] ?? 'La raza es obligatoria.'; ?></div>
          </div>

          <div class="col-md-4">
            <label for="edad" class="form-label">Edad (años) *</label>
            <input type="number" class="form-control <?php echo $claseError('edad'); ?>" id="edad" name="edad"
                   min="0" max="30" step="1" required value="<?php echo $valor('edad'); ?>">
            <div class="invalid-feedback"><?php echo $errores['edad'] ?? 'Ingresá una edad entre 0 y 30.'; ?></div>
          </div>

          <div class="col-md-4">
            <label for="sexo" class="form-label">Sexo *</label>
            <select class="form-select <?php echo $claseError('sexo'); ?>" id="sexo" name="sexo" required>
              <option value="">Seleccionar...</option>
              <?php foreach ($sexos as $sexo): ?>
                <option value="<?php echo $sexo; ?>" <?php echo ($gato['sexo'] ?? '') === $sexo ? 'selected' : ''; ?>><?php echo $sexo; ?></option>
              <?php endforeach; ?>
            </select>
            <div class="invalid-feedback"><?php echo $errores['sexo'] ?? 'Seleccioná el sexo.'; ?></div>
          </div>

          <div class="col-md-4">
            <label for="precio" class="form-label">Precio ($) *</label>
            <input type="number" class="form-control <?php echo $claseError('precio'); ?>" id="precio" name="precio"
                   min="0" step="0.01" required value="<?php echo $valor('precio'); ?>">
            <div class="invalid-feedback"><?php echo $errores['precio'] ?? 'Ingresá un precio mayor o igual a 0.'; ?></div>
          </div>

          <div class="col-12">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control <?php echo $claseError('descripcion'); ?>" id="descripcion" name="descripcion"
                      rows="3" maxlength="500"><?php echo $valor('descripcion'); ?></textarea>
            <div class="invalid-feedback"><?php echo $errores['descripcion'] ?? 'Máximo 500 caracteres.'; ?></div>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
          <a href="index.php?accion=gatos" class="btn btn-outline-secondary">Cancelar</a>
          <button type="submit" class="btn btn-primary"><?php echo $id ? 'Guardar cambios' : 'Dar de alta'; ?></button>
        </div>
      </form>
    </div>
  </div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
