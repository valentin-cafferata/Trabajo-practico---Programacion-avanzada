<?php
require_once __DIR__ . '/../../helpers/Foto.php';
$scriptsExtra = ['views/assets/js/gato-form.js'];
require __DIR__ . '/../includes/header.php';

$valor = fn($campo) => htmlspecialchars((string) ($gato[$campo] ?? ''));
$claseError = fn($campo) => isset($errores[$campo]) ? 'is-invalid' : '';
$fotoActual = $id ? Foto::url($gato['foto'] ?? null) : null;
?>

  <div class="container py-4 d-flex justify-content-center">
    <div class="bg-white p-4 p-md-5 rounded-4 shadow" style="max-width: 900px; width: 100%;">
      <h2 class="fw-bold mb-1"><?php echo $id ? 'Editar publicación' : 'Publicar un gato'; ?></h2>
      <p class="text-muted mb-4">Completá los datos y subí una foto. Así se verá en el marketplace.</p>

      <?php if ($errores): ?>
        <div class="alert alert-danger">Revisá los campos marcados en rojo.</div>
      <?php endif; ?>

      <form id="form-gato" action="index.php?accion=<?php echo $id ? 'gato_actualizar' : 'gato_guardar'; ?>" method="POST" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="csrf" value="<?php echo Controller::tokenCsrf(); ?>">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo Foto::MAX_BYTES; ?>">
        <?php if ($id): ?>
          <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php endif; ?>

        <div class="row g-4">
          <!-- Foto -->
          <div class="col-md-5">
            <label class="form-label">Foto <?php echo $id ? '' : '*'; ?></label>
            <div class="ratio ratio-1x1 rounded-4 overflow-hidden bg-light border mb-2 <?php echo isset($errores['foto']) ? 'border-danger' : ''; ?>" id="foto-marco">
              <img id="foto-preview" src="<?php echo htmlspecialchars($fotoActual ?? Foto::PLACEHOLDER); ?>" alt="Vista previa" class="object-fit-cover">
            </div>
            <input type="file" class="form-control <?php echo $claseError('foto'); ?>" id="foto" name="foto"
                   accept="image/jpeg,image/png,image/webp" data-max-bytes="<?php echo Foto::MAX_BYTES; ?>" <?php echo $id ? '' : 'required'; ?>>
            <div class="invalid-feedback" id="foto-error"><?php echo $errores['foto'] ?? 'Subí una foto JPG, PNG o WEBP de hasta 3 MB.'; ?></div>
            <div class="form-text">
              <?php echo $id ? 'Si no elegís una foto nueva, se conserva la actual.' : 'JPG, PNG o WEBP de hasta 3 MB.'; ?>
            </div>
          </div>

          <!-- Datos -->
          <div class="col-md-7">
            <div class="row g-3">
              <div class="col-12">
                <label for="nombre" class="form-label">Nombre *</label>
                <input type="text" class="form-control <?php echo $claseError('nombre'); ?>" id="nombre" name="nombre"
                       maxlength="100" required value="<?php echo $valor('nombre'); ?>">
                <div class="invalid-feedback"><?php echo $errores['nombre'] ?? 'El nombre es obligatorio.'; ?></div>
              </div>

              <div class="col-sm-7">
                <label for="raza" class="form-label">Raza *</label>
                <input type="text" class="form-control <?php echo $claseError('raza'); ?>" id="raza" name="raza"
                       maxlength="60" required value="<?php echo $valor('raza'); ?>">
                <div class="invalid-feedback"><?php echo $errores['raza'] ?? 'La raza es obligatoria.'; ?></div>
              </div>

              <div class="col-sm-5">
                <label for="sexo" class="form-label">Sexo *</label>
                <select class="form-select <?php echo $claseError('sexo'); ?>" id="sexo" name="sexo" required>
                  <option value="">Seleccionar...</option>
                  <?php foreach ($sexos as $sexo): ?>
                    <option value="<?php echo $sexo; ?>" <?php echo ($gato['sexo'] ?? '') === $sexo ? 'selected' : ''; ?>><?php echo $sexo; ?></option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback"><?php echo $errores['sexo'] ?? 'Seleccioná el sexo.'; ?></div>
              </div>

              <div class="col-sm-5">
                <label for="edad" class="form-label">Edad (años) *</label>
                <input type="number" class="form-control <?php echo $claseError('edad'); ?>" id="edad" name="edad"
                       min="0" max="30" step="1" required value="<?php echo $valor('edad'); ?>">
                <div class="invalid-feedback"><?php echo $errores['edad'] ?? 'Ingresá una edad entre 0 y 30.'; ?></div>
              </div>

              <div class="col-sm-7">
                <label for="precio" class="form-label">Precio ($) *</label>
                <input type="number" class="form-control <?php echo $claseError('precio'); ?>" id="precio" name="precio"
                       min="0" step="0.01" required value="<?php echo $valor('precio'); ?>">
                <div class="invalid-feedback"><?php echo $errores['precio'] ?? 'Ingresá un precio mayor o igual a 0.'; ?></div>
              </div>

              <div class="col-12">
                <label for="ubicacion" class="form-label">Ubicación *</label>
                <input type="text" class="form-control <?php echo $claseError('ubicacion'); ?>" id="ubicacion" name="ubicacion"
                       maxlength="100" required placeholder="Ciudad, Provincia" value="<?php echo $valor('ubicacion'); ?>">
                <div class="invalid-feedback"><?php echo $errores['ubicacion'] ?? 'La ubicación es obligatoria.'; ?></div>
              </div>

              <div class="col-12">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control <?php echo $claseError('descripcion'); ?>" id="descripcion" name="descripcion"
                          rows="4" maxlength="1000" placeholder="Contá cómo es, qué le gusta, si tiene vacunas..."><?php echo $valor('descripcion'); ?></textarea>
                <div class="invalid-feedback"><?php echo $errores['descripcion'] ?? 'Máximo 1000 caracteres.'; ?></div>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
          <a href="index.php?accion=mis_publicaciones" class="btn btn-outline-secondary">Cancelar</a>
          <button type="submit" class="btn btn-primary px-4"><?php echo $id ? 'Guardar cambios' : 'Publicar'; ?></button>
        </div>
      </form>
    </div>
  </div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
