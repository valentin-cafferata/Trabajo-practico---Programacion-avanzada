<?php
session_start();

// Si NO está logueado, lo mandamos al login
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$tituloPagina = 'Inicio Privado';
require_once __DIR__ . '/includes/header.php';
?> 
  
  <div class="container py-5 d-flex justify-content-center">
    <div class="bg-white p-5 rounded-4 shadow text-center" style="max-width: 600px; width: 100%;">
      <h1 class="text-dark fw-bold mb-3">Marketplace de gatos fieros</h1>
      <!-- Se muestra el nombre del usuario logueado -->
      <p class="text-muted fs-5 mb-0">
        Bienvenido al sistema de administración, <?php echo htmlspecialchars($_SESSION['usuario']); ?>.
      </p>
    </div>
  </div>
  
<?php require_once __DIR__ . '/includes/footer.php'; ?>