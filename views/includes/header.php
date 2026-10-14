<?php
// Las vistas solo se cargan a través de index.php (front controller)
if (!defined('APP_INICIADA')) {
    http_response_code(403);
    exit('Acceso no permitido. Ingresá desde la página principal.');
}

$tituloPagina = $tituloPagina ?? 'Marketplace de Gatitos';
$accionActual = $_GET['accion'] ?? '';
$logueado = isset($_SESSION['usuario']);
$flash = $flash ?? null;
$estilosExtra = $estilosExtra ?? [];

$activo = fn($acciones) => in_array($accionActual, (array) $acciones, true) ? 'active' : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($tituloPagina); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <?php foreach ($estilosExtra as $href): ?>
  <link href="<?php echo $href; ?>" rel="stylesheet">
  <?php endforeach; ?>
  <link href="views/assets/css/navbar.css" rel="stylesheet">
  <link href="views/assets/css/body.css" rel="stylesheet">
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
          <img src="views/assets/img/logo.png" alt="Logo Marketplace" width="50" height="50" class="d-inline-block align-text-top">
        </a>
        <ul class="navbar-nav flex-row gap-3 me-auto mb-0">
          <?php if ($logueado): ?>
            <li class="nav-item">
              <a class="nav-link <?php echo $activo('inicio'); ?>" href="index.php?accion=inicio">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo $activo(['gatos', 'gato_nuevo', 'gato_guardar', 'gato_editar', 'gato_actualizar']); ?>" href="index.php?accion=gatos">Gatos</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link <?php echo $activo(''); ?>" href="index.php">Home</a>
            </li>
          <?php endif; ?>
        </ul>
        <div class="d-flex align-items-center">
          <img src="views/assets/img/profile.png" alt="Perfil" width="40" height="40" class="rounded-circle me-3">
          <?php if ($logueado): ?>
            <span class="text-light fw-bold me-3">
              Logueado como: <?php echo htmlspecialchars($_SESSION['usuario']); ?>
            </span>
            <a href="index.php?accion=logout" class="btn btn-outline-light btn-sm">Salir</a>
          <?php elseif ($accionActual !== 'login'): ?>
            <a href="index.php?accion=login" class="nav-link">Login</a>
          <?php endif; ?>
        </div>
      </div>
    </nav>
  </header>
  <main>
    <?php if ($flash): ?>
      <div class="container mt-3">
        <div class="alert alert-<?php echo htmlspecialchars($flash['tipo']); ?> alert-dismissible fade show shadow-sm" role="alert">
          <?php echo htmlspecialchars($flash['mensaje']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
      </div>
    <?php endif; ?>
