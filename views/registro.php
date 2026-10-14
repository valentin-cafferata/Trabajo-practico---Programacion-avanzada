<?php
$scriptsExtra = [
    'https://www.google.com/recaptcha/api.js',
    'views/assets/js/registro.js',
];
require __DIR__ . '/includes/header.php';

$valor = fn($campo) => htmlspecialchars($datos[$campo] ?? '');
$claseError = fn($campo) => isset($errores[$campo]) ? 'is-invalid' : '';
?>
<div class="d-flex justify-content-center align-items-center py-4" style="min-height: calc(100vh - 140px);">
  <div class="card shadow-sm border-0 p-4 rounded-4" style="max-width: 460px; width: 100%;">
    <div class="text-center mb-4">
      <h5 class="text-primary fw-bold">Marketplace de gatos fieros</h5>
      <h3 class="fw-bold">Crear cuenta</h3>
      <p class="text-muted">Registrate para publicar tus gatos</p>
    </div>

    <?php if (isset($errores['captcha'])): ?>
      <div class="alert alert-danger"><?php echo $errores['captcha']; ?></div>
    <?php endif; ?>

    <form id="form-registro" action="index.php?accion=registrar" method="POST" novalidate>
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre y apellido</label>
        <input type="text" class="form-control rounded-3 <?php echo $claseError('nombre'); ?>" id="nombre" name="nombre"
               maxlength="100" required value="<?php echo $valor('nombre'); ?>">
        <div class="invalid-feedback"><?php echo $errores['nombre'] ?? 'Ingresá tu nombre.'; ?></div>
      </div>
      <div class="mb-3">
        <label for="usuario" class="form-label">Nombre de usuario</label>
        <input type="text" class="form-control rounded-3 <?php echo $claseError('usuario'); ?>" id="usuario" name="usuario"
               minlength="3" maxlength="50" pattern="[A-Za-z0-9._-]+" required autocomplete="username" value="<?php echo $valor('usuario'); ?>">
        <div class="invalid-feedback"><?php echo $errores['usuario'] ?? 'Entre 3 y 50 caracteres: letras, números, punto, guion o guion bajo.'; ?></div>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control rounded-3 <?php echo $claseError('password'); ?>" id="password" name="password"
               minlength="6" maxlength="100" required autocomplete="new-password">
        <div class="invalid-feedback"><?php echo $errores['password'] ?? 'La contraseña debe tener al menos 6 caracteres.'; ?></div>
      </div>
      <div class="mb-3">
        <label for="password2" class="form-label">Repetir contraseña</label>
        <input type="password" class="form-control rounded-3 <?php echo $claseError('password2'); ?>" id="password2" name="password2"
               maxlength="100" required autocomplete="new-password">
        <div class="invalid-feedback" id="password2-error"><?php echo $errores['password2'] ?? 'Las contraseñas no coinciden.'; ?></div>
      </div>

      <div class="mb-3">
        <div class="g-recaptcha" data-sitekey="6LeRirktAAAAAKGHNZULA-G9Zt0AfYAadcQQfGHP"></div>
      </div>

      <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 mb-3">Crear cuenta</button>

      <p class="text-center text-muted mb-0">
        ¿Ya tenés cuenta? <a href="index.php?accion=login" class="fw-semibold">Iniciá sesión</a>
      </p>
    </form>
  </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
