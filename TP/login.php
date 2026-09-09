<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link href="css/navbar.css" rel="stylesheet">
  <link href="css/body.css?v=3" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <img src="img/logo.png" alt="Logo Marketplace" width="50" height="50" class="d-inline-block align-text-top">
      </a>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
      </ul>
     <a href="login.php" class="nav-link">Login</a>
    </div>
  </nav>

  <div class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 80px);">
    <div class="card shadow-sm border-0 p-4 rounded-4" style="max-width: 420px; width: 100%;">
      <div class="text-center mb-4">
        <h5 class="text-primary fw-bold">Marketplace de Gatitos</h5>
        <h3 class="fw-bold">Bienvenido de nuevo</h3>
        <p class="text-muted">Ingresa tus datos para continuar</p>
      </div>

      <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">Usuario o contraseña incorrectos.</div>
      <?php endif; ?>

      <form id="miForm" action="procesoLogin.php" method="POST">
        <div id="alerta-contenedor"></div>
        <div class="mb-3">
          <input type="text" class="form-control form-control-lg rounded-3" id="usuario" name="usuario" placeholder="Usuario">
        </div>
        <div class="mb-3">
          <input type="password" class="form-control form-control-lg rounded-3" id="password" name="password" placeholder="Contraseña">
        </div>
        <button type="submit" id="submit-btn" class="btn btn-primary btn-lg w-100 rounded-3 mb-2" disabled>Ingresar</button>
      </form>
    </div>
  </div>
  <footer class="footer text-white text-center py-2 fixed-bottom">
  <p class="mb-0">Programación Avanzada © 2026</p>
</footer>
 <script src="js/validation.js?v=2"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
