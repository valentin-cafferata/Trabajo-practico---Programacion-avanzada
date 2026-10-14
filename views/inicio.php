<?php require __DIR__ . '/includes/header.php'; ?>

  <div class="container py-5 d-flex justify-content-center">
    <div class="bg-white p-5 rounded-4 shadow text-center" style="max-width: 600px; width: 100%;">
      <h1 class="text-dark fw-bold mb-3">Marketplace de gatos fieros</h1>
      <p class="text-muted fs-5">
        Bienvenido al sistema de administración, <?php echo htmlspecialchars($_SESSION['nombre'] ?? $_SESSION['usuario']); ?>.
      </p>
      <p class="fs-5 mb-4">Hay <strong><?php echo $totalGatos; ?></strong> gato(s) publicados.</p>
      <a href="index.php?accion=gatos" class="btn btn-primary btn-lg px-4">Administrar gatos</a>
    </div>
  </div>

<?php require __DIR__ . '/includes/footer.php'; ?>
