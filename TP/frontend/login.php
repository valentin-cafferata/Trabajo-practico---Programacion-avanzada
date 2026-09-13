<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

$tituloPagina = 'Login';
require_once __DIR__ . '/includes/header.php';
?>
  <div class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 140px);">
    <div class="card shadow-sm border-0 p-4 rounded-4" style="max-width: 420px; width: 100%;">
      <div class="text-center mb-4">
        <h5 class="text-primary fw-bold">Marketplace de gatos feos</h5>
        <h3 class="fw-bold">Bienvenido de nuevo</h3>
        <p class="text-muted">Ingresa tus datos para continuar</p>
      </div>

      <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">Usuario o contraseña incorrectos.</div>
      <?php endif; ?>

      <form id="miForm" action="../backend/procesoLogin.php" method="POST">
        <div class="mb-3">
          <input type="text" class="form-control form-control-lg rounded-3" id="usuario" name="usuario" placeholder="Usuario">
        </div>
        <div class="mb-3">
          <input type="password" class="form-control form-control-lg rounded-3" id="password" name="password" placeholder="Contraseña">
        </div>

        <div class="g-recaptcha" data-sitekey="6LeRirktAAAAAKGHNZULA-G9Zt0AfYAadcQQfGHP"></div>

        <button type="submit" id="submit-btn" class="btn btn-primary btn-lg w-100 rounded-3 mb-2" disabled>Ingresar</button>
      </form>
    </div>
  </div>
  <script src="assets/js/validation.js"></script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
