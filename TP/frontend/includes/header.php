<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($tituloPagina)) {
    $tituloPagina = 'Marketplace de Gatitos';
}
$paginaActual = basename($_SERVER['PHP_SELF']);
$desdeBackend = basename(dirname($_SERVER['SCRIPT_FILENAME'])) === 'backend';
$front = $desdeBackend ? '../frontend/' : '';
$auth = $desdeBackend ? '' : '../backend/';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($tituloPagina); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link href="<?php echo $front; ?>assets/css/navbar.css" rel="stylesheet">
  <link href="<?php echo $front; ?>assets/css/body.css" rel="stylesheet">

  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo $front; ?>index.php">
          <img src="<?php echo $front; ?>assets/img/logo.png" alt="Logo Marketplace" width="50" height="50" class="d-inline-block align-text-top">
        </a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link <?php echo $paginaActual === 'index.php' ? 'active' : ''; ?>" href="<?php echo $front; ?>index.php">Home</a>
          </li>
        </ul>
        <div class="d-flex align-items-center">
          <?php if (isset($_SESSION['usuario'])): ?>
            <span class="text-light fw-bold me-3">
              Logueado como: <?php echo htmlspecialchars($_SESSION['usuario']); ?>
            </span>
            <a href="<?php echo $auth; ?>logout.php" class="btn btn-outline-light btn-sm">Salir</a>
          <?php elseif ($paginaActual !== 'login.php'): ?>
            <a href="<?php echo $front; ?>login.php" class="nav-link">Login</a>
          <?php endif; ?>
        </div>
      </div>
    </nav>
  </header>
  <main>
