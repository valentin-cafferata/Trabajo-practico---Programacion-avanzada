<?php
session_start();

// Si ya está logueado, lo mandamos a inicio.php y cortamos la ejecución
if (isset($_SESSION['usuario'])) {
    header('Location: inicio.php');
    exit();
}

$tituloPagina = 'Home Público';
require_once __DIR__ . '/includes/header.php';
?> 
  
  <div class="container py-5 d-flex justify-content-center">
    <div class="bg-white p-5 rounded-4 shadow text-center" style="max-width: 600px; width: 100%;">
      <h1 class="text-dark fw-bold mb-3">Marketplace de gatos fieros</h1>
      <p class="text-muted fs-5 mb-0">Bienvenido al sistema.</p>
    </div>
  </div>
  
<?php require_once __DIR__ . '/includes/footer.php'; ?>