<?php
// Las vistas solo se cargan a través de index.php (front controller)
if (!defined('APP_INICIADA')) {
    http_response_code(403);
    exit('Acceso no permitido. Ingresá desde la página principal.');
}

$tituloPagina = $tituloPagina ?? 'Marketplace de gatos fieros';
$accionActual = $_GET['accion'] ?? '';
$logueado = isset($_SESSION['usuario_id']);
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
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
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
          <img src="views/assets/img/logo.png" alt="Logo Marketplace" width="44" height="44" class="d-inline-block">
          <span class="fw-bold d-none d-sm-inline">Gatos fieros</span>
        </a>
        <ul class="navbar-nav flex-row gap-3 me-auto mb-0">
          <li class="nav-item">
            <a class="nav-link <?php echo $activo(['', 'publicacion']); ?>" href="index.php">
              <i class="bi bi-shop"></i> Marketplace
            </a>
          </li>
          <?php if ($logueado): ?>
            <li class="nav-item">
              <a class="nav-link <?php echo $activo(['mis_publicaciones', 'gato_editar', 'gato_actualizar', 'gato_eliminar']); ?>" href="index.php?accion=mis_publicaciones">
                <i class="bi bi-collection"></i> Mis publicaciones
              </a>
            </li>
          <?php endif; ?>
        </ul>
        <div class="d-flex align-items-center gap-2">
          <?php if ($logueado): ?>
            <a href="index.php?accion=gato_nuevo" class="btn btn-light btn-sm fw-semibold text-primary">
              <i class="bi bi-plus-lg"></i> Publicar
            </a>
            <img src="views/assets/img/profile.png" alt="Perfil" width="36" height="36" class="rounded-circle ms-2">
            <span class="text-light fw-bold d-none d-md-inline">
              <?php echo htmlspecialchars($_SESSION['nombre'] ?? $_SESSION['usuario']); ?>
            </span>
            <a href="index.php?accion=logout" class="btn btn-outline-light btn-sm">Salir</a>
          <?php else: ?>
            <a href="index.php?accion=login" class="btn btn-outline-light btn-sm <?php echo $accionActual === 'login' ? 'active' : ''; ?>">Iniciar sesión</a>
            <a href="index.php?accion=registro" class="btn btn-light btn-sm fw-semibold text-primary">Crear cuenta</a>
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
