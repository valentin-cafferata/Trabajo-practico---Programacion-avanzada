<?php
require_once __DIR__ . '/../helpers/Foto.php';
require __DIR__ . '/includes/header.php';

$f = fn($campo) => htmlspecialchars($filtros[$campo]);
?>

  <div class="container-fluid py-4 px-lg-4">
    <div class="row g-4">

      <!-- Filtros (columna izquierda, como en Facebook Marketplace) -->
      <aside class="col-lg-3 col-xl-2">
        <div class="bg-white rounded-4 shadow p-3 sticky-lg-top" style="top: 1rem;">
          <h5 class="fw-bold mb-3"><i class="bi bi-funnel"></i> Filtros</h5>
          <form method="GET" action="index.php" id="form-filtros">
            <div class="mb-3">
              <label for="q" class="form-label small text-muted mb-1">Buscar</label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="search" class="form-control" id="q" name="q" placeholder="Raza, nombre, ciudad..." value="<?php echo $f('q'); ?>">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label small text-muted mb-1">Precio</label>
              <div class="d-flex gap-2">
                <input type="number" class="form-control form-control-sm" name="precio_min" placeholder="Mín." min="0" value="<?php echo $f('precio_min'); ?>">
                <input type="number" class="form-control form-control-sm" name="precio_max" placeholder="Máx." min="0" value="<?php echo $f('precio_max'); ?>">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label small text-muted mb-1">Sexo</label>
              <?php foreach (['' => 'Todos', 'Macho' => 'Macho', 'Hembra' => 'Hembra'] as $valor => $texto): ?>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="sexo" id="sexo-<?php echo $valor ?: 'todos'; ?>" value="<?php echo $valor; ?>" <?php echo $filtros['sexo'] === $valor ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="sexo-<?php echo $valor ?: 'todos'; ?>"><?php echo $texto; ?></label>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="mb-3">
              <label for="orden" class="form-label small text-muted mb-1">Ordenar por</label>
              <select class="form-select form-select-sm" id="orden" name="orden">
                <option value="recientes" <?php echo $filtros['orden'] === 'recientes' ? 'selected' : ''; ?>>Más recientes</option>
                <option value="precio_asc" <?php echo $filtros['orden'] === 'precio_asc' ? 'selected' : ''; ?>>Precio: menor a mayor</option>
                <option value="precio_desc" <?php echo $filtros['orden'] === 'precio_desc' ? 'selected' : ''; ?>>Precio: mayor a menor</option>
              </select>
            </div>

            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary btn-sm">Aplicar</button>
              <?php if ($hayFiltros): ?>
                <a href="index.php" class="btn btn-outline-secondary btn-sm">Limpiar filtros</a>
              <?php endif; ?>
            </div>
          </form>
        </div>
      </aside>

      <!-- Publicaciones -->
      <section class="col-lg-9 col-xl-10">
        <div class="bg-white rounded-4 shadow p-4">
          <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div>
              <h2 class="fw-bold mb-0"><?php echo $hayFiltros ? 'Resultados' : 'Publicaciones recientes'; ?></h2>
              <small class="text-muted"><?php echo count($gatos); ?> gato(s) publicados</small>
            </div>
            <?php if ($logueado): ?>
              <a href="index.php?accion=gato_nuevo" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Publicar un gato</a>
            <?php else: ?>
              <a href="index.php?accion=login" class="btn btn-outline-primary"><i class="bi bi-box-arrow-in-right"></i> Iniciá sesión para publicar</a>
            <?php endif; ?>
          </div>

          <?php if (!$gatos): ?>
            <div class="text-center text-muted py-5">
              <div class="display-3">😿</div>
              <p class="fs-5 mb-1">No encontramos gatos con esos filtros.</p>
              <a href="index.php">Ver todas las publicaciones</a>
            </div>
          <?php else: ?>
            <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-5 g-3">
              <?php foreach ($gatos as $gato): ?>
                <div class="col">
                  <a href="index.php?accion=publicacion&amp;id=<?php echo $gato['id']; ?>" class="card card-gato h-100 text-decoration-none text-dark border-0">
                    <div class="ratio ratio-1x1 rounded-3 overflow-hidden bg-light">
                      <img src="<?php echo htmlspecialchars(Foto::url($gato['foto'])); ?>" class="object-fit-cover" alt="<?php echo htmlspecialchars($gato['nombre']); ?>" loading="lazy">
                    </div>
                    <div class="card-body px-1 py-2">
                      <div class="fw-bold fs-5">$ <?php echo number_format($gato['precio'], fmod($gato['precio'], 1) ? 2 : 0, ',', '.'); ?></div>
                      <div class="text-truncate"><?php echo htmlspecialchars($gato['nombre']); ?> · <?php echo htmlspecialchars($gato['raza']); ?></div>
                      <div class="small text-muted text-truncate">
                        <?php echo $gato['edad']; ?> año(s) · <?php echo $gato['sexo']; ?>
                      </div>
                      <div class="small text-muted text-truncate"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($gato['ubicacion']); ?></div>
                    </div>
                  </a>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </section>

    </div>
  </div>

<?php require __DIR__ . '/includes/footer.php'; ?>
