<?php require __DIR__ . '/includes/header.php'; ?>

  <div class="container py-5 d-flex justify-content-center">
    <div class="bg-white p-5 rounded-4 shadow text-center" style="max-width: 600px; width: 100%;">
      <div class="display-1 mb-3">😿</div>
      <?php if ($sinConexion): ?>
        <h2 class="fw-bold mb-3">No pudimos conectarnos con la base de datos</h2>
        <p class="text-muted fs-5">
          El sistema no está disponible en este momento. Por favor, intentá de nuevo en unos minutos.
        </p>
      <?php else: ?>
        <h2 class="fw-bold mb-3">Ocurrió un problema con la base de datos</h2>
        <p class="text-muted fs-5">
          No se pudo completar la operación. Por favor, intentá de nuevo más tarde.
        </p>
      <?php endif; ?>
      <a href="index.php" class="btn btn-primary mt-3">Reintentar</a>
    </div>
  </div>

<?php require __DIR__ . '/includes/footer.php'; ?>
