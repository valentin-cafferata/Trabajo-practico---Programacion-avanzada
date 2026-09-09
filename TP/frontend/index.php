<?php
session_start();
$tituloPagina = 'Home';
require_once __DIR__ . '/includes/header.php';
?>
  <div class="container py-5">
    <h1 class="text-center text-white">Marketplace de Gatitos</h1>
    <p class="text-center text-white">Bienvenido al sistema de administración.</p>
  </div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
