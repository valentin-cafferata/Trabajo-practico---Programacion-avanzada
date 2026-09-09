<?php
session_start();
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="css/navbar.css" rel="stylesheet">
    <link href="css/body.css" rel="stylesheet">
  </head>
  <body>
    
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
          <img src="img/logo.png" alt="Logo Marketplace" width="50" height="50" class="d-inline-block align-text-top">
        </a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
        </ul>
        <div class="d-flex align-items-center">
          <?php if (isset($_SESSION['usuario'])): ?>
            <span class="text-light fw-bold me-3">
              <?php echo htmlspecialchars($_SESSION['usuario']); ?>
            </span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Salir</a>
          <?php else: ?>
            <a href="login.php" class="nav-link">Login</a>
          <?php endif; ?>
        </div>
      </div>
    </nav>
    <?php if (isset($_SESSION['usuario'])): ?>
  <div id="mensaje-ingreso" class="alert alert-success text-center">
    Ingreso correctamente
  </div>
<?php endif; ?>
   <footer class="footer text-white text-center py-2 fixed-bottom">
  <p class="mb-0">Programación Avanzada © 2026</p>
</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script>
  setTimeout(function () {
    const mensaje = document.getElementById("mensaje-ingreso");

    if (mensaje) {
      mensaje.style.display = "none";
    }
  }, 4000);
</script>
  </body>
</html>
