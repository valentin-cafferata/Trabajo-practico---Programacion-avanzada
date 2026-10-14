<?php
require_once __DIR__ . '/../helpers/Foto.php';
$scriptsExtra = $esDuenio ? ['https://cdn.jsdelivr.net/npm/sweetalert2@11', 'views/assets/js/gatos.js'] : [];
require __DIR__ . '/includes/header.php';

$fecha = new DateTime($gato['created_at']);
?>

  <div class="container py-4">
    <a href="index.php" class="btn btn-light shadow-sm mb-3"><i class="bi bi-arrow-left"></i> Volver al marketplace</a>

    <div class="bg-white rounded-4 shadow overflow-hidden">
      <div class="row g-0">
        <div class="col-lg-7 bg-dark d-flex align-items-center justify-content-center">
          <img src="<?php echo htmlspecialchars(Foto::url($gato['foto'])); ?>" alt="<?php echo htmlspecialchars($gato['nombre']); ?>"
               class="img-fluid w-100" style="max-height: 75vh; object-fit: contain;">
        </div>

        <div class="col-lg-5 p-4 p-lg-5 d-flex flex-column">
          <h1 class="fw-bold mb-1"><?php echo htmlspecialchars($gato['nombre']); ?></h1>
          <div class="fs-2 fw-bold text-primary mb-2">$ <?php echo number_format($gato['precio'], 2, ',', '.'); ?></div>
          <div class="text-muted mb-4">
            <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($gato['ubicacion']); ?>
            · Publicado el <?php echo $fecha->format('d/m/Y'); ?>
          </div>

          <h5 class="fw-bold">Detalles</h5>
          <dl class="row mb-4">
            <dt class="col-5 fw-normal text-muted">Raza</dt>
            <dd class="col-7"><?php echo htmlspecialchars($gato['raza']); ?></dd>
            <dt class="col-5 fw-normal text-muted">Edad</dt>
            <dd class="col-7"><?php echo $gato['edad']; ?> año(s)</dd>
            <dt class="col-5 fw-normal text-muted">Sexo</dt>
            <dd class="col-7"><?php echo $gato['sexo']; ?></dd>
          </dl>

          <?php if ($gato['descripcion']): ?>
            <h5 class="fw-bold">Descripción</h5>
            <p class="mb-4" style="white-space: pre-line;"><?php echo htmlspecialchars($gato['descripcion']); ?></p>
          <?php endif; ?>

          <div class="mt-auto">
            <h5 class="fw-bold">Información del vendedor</h5>
            <div class="d-flex align-items-center gap-3 p-3 border rounded-3 mb-3">
              <img src="views/assets/img/profile.png" alt="Perfil" width="48" height="48" class="rounded-circle">
              <div>
                <div class="fw-semibold"><?php echo htmlspecialchars($gato['publicador']); ?></div>
                <div class="small text-muted">@<?php echo htmlspecialchars($gato['publicador_usuario']); ?></div>
              </div>
            </div>

            <?php if ($esDuenio): ?>
              <div class="d-flex gap-2">
                <a href="index.php?accion=gato_editar&amp;id=<?php echo $gato['id']; ?>" class="btn btn-primary flex-fill"><i class="bi bi-pencil"></i> Editar</a>
                <form action="index.php?accion=gato_eliminar" method="POST" class="form-eliminar flex-fill" data-nombre="<?php echo htmlspecialchars($gato['nombre']); ?>">
                  <input type="hidden" name="csrf" value="<?php echo Controller::tokenCsrf(); ?>">
                  <input type="hidden" name="id" value="<?php echo $gato['id']; ?>">
                  <button type="submit" class="btn btn-outline-danger w-100"><i class="bi bi-trash"></i> Eliminar</button>
                </form>
              </div>
            <?php else: ?>
              <button type="button" class="btn btn-primary w-100 btn-lg" data-bs-toggle="modal" data-bs-target="#modal-contacto">
                <i class="bi bi-chat-dots"></i> Contactar al vendedor
              </button>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php if (!$esDuenio): ?>
  <div class="modal fade" id="modal-contacto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4">
        <div class="modal-header border-0">
          <h5 class="modal-title fw-bold">Contactar a <?php echo htmlspecialchars($gato['publicador']); ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <p class="text-muted">Mandale un mensaje por <?php echo htmlspecialchars($gato['nombre']); ?>:</p>
          <textarea class="form-control" rows="3" readonly>Hola <?php echo htmlspecialchars($gato['publicador']); ?>, ¿sigue disponible <?php echo htmlspecialchars($gato['nombre']); ?>?</textarea>
          <p class="small text-muted mt-3 mb-0">El envío de mensajes no está implementado en esta versión del trabajo práctico.</p>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
