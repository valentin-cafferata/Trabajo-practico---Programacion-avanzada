<?php
$scriptsExtra = [
    'https://www.google.com/recaptcha/api.js',
    'views/assets/js/validation.js',
];
require __DIR__ . '/includes/header.php';
?>
<div class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 140px);">
  <div class="card shadow-sm border-0 p-4 rounded-4" style="max-width: 420px; width: 100%;">
    <div class="text-center mb-4">
      <h5 class="text-primary fw-bold">Marketplace de gatos fieros</h5>
      <h3 class="fw-bold">Bienvenido de nuevo</h3>
      <p class="text-muted">Iniciá sesión para publicar tus gatos</p>
    </div>

    <form id="miForm" action="index.php?accion=autenticar" method="POST" novalidate>
      <div class="mb-3">
        <input type="text" class="form-control form-control-lg rounded-3" id="usuario" name="usuario" placeholder="Usuario"
               maxlength="50" autocomplete="username" value="<?php echo htmlspecialchars($usuarioPrevio); ?>">
        <div class="invalid-feedback" id="usuario-error"></div>
      </div>
      <div class="mb-3">
        <input type="password" class="form-control form-control-lg rounded-3" id="password" name="password" placeholder="Contraseña"
               maxlength="100" autocomplete="current-password">
        <div class="invalid-feedback" id="password-error"></div>
      </div>

      <div class="mb-3">
        <div class="g-recaptcha" data-sitekey="6LeRirktAAAAAKGHNZULA-G9Zt0AfYAadcQQfGHP"></div>
      </div>

      <button type="submit" id="submit-btn" class="btn btn-primary btn-lg w-100 rounded-3 mb-3" disabled>Ingresar</button>

      <p class="text-center text-muted mb-0">
        ¿No tenés cuenta? <a href="index.php?accion=registro" class="fw-semibold">Registrate</a>
      </p>
    </form>
  </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
