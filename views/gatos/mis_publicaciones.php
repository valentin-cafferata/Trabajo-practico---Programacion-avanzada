<?php
require_once __DIR__ . '/../../helpers/Foto.php';
$estilosExtra = ['https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css'];
$scriptsExtra = [
    'https://code.jquery.com/jquery-3.7.1.min.js',
    'https://cdn.datatables.net/2.1.8/js/dataTables.min.js',
    'https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js',
    'https://cdn.jsdelivr.net/npm/sweetalert2@11',
    'views/assets/js/gatos.js',
];
require __DIR__ . '/../includes/header.php';
?>

  <div class="container py-4">
    <div class="bg-white p-4 rounded-4 shadow">
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
          <h2 class="fw-bold mb-0">Mis publicaciones</h2>
          <small class="text-muted">Acá podés dar de alta, modificar o eliminar tus gatos publicados.</small>
        </div>
        <a href="index.php?accion=gato_nuevo" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Publicar un gato</a>
      </div>

      <?php if (!$gatos): ?>
        <div class="text-center text-muted py-5">
          <div class="display-3">🐱</div>
          <p class="fs-5">Todavía no publicaste ningún gato.</p>
          <a href="index.php?accion=gato_nuevo" class="btn btn-primary">Publicar el primero</a>
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table id="tabla-gatos" class="table table-hover align-middle w-100">
            <thead>
              <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Raza</th>
                <th>Edad</th>
                <th>Sexo</th>
                <th>Precio</th>
                <th>Ubicación</th>
                <th>Publicado</th>
                <th class="text-end">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($gatos as $gato): ?>
                <tr>
                  <td>
                    <a href="index.php?accion=publicacion&amp;id=<?php echo $gato['id']; ?>">
                      <img src="<?php echo htmlspecialchars(Foto::url($gato['foto'])); ?>" alt="" width="56" height="56" class="rounded-3 object-fit-cover">
                    </a>
                  </td>
                  <td class="fw-semibold">
                    <a href="index.php?accion=publicacion&amp;id=<?php echo $gato['id']; ?>" class="text-dark"><?php echo htmlspecialchars($gato['nombre']); ?></a>
                  </td>
                  <td><?php echo htmlspecialchars($gato['raza']); ?></td>
                  <td class="text-nowrap" data-order="<?php echo $gato['edad']; ?>"><?php echo $gato['edad']; ?> año(s)</td>
                  <td><?php echo $gato['sexo']; ?></td>
                  <td class="text-nowrap" data-order="<?php echo $gato['precio']; ?>">$ <?php echo number_format($gato['precio'], 2, ',', '.'); ?></td>
                  <td class="small"><?php echo htmlspecialchars($gato['ubicacion']); ?></td>
                  <td class="text-nowrap small" data-order="<?php echo $gato['created_at']; ?>"><?php echo (new DateTime($gato['created_at']))->format('d/m/Y'); ?></td>
                  <td class="text-end text-nowrap">
                    <a href="index.php?accion=gato_editar&amp;id=<?php echo $gato['id']; ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i> Editar</a>
                    <form action="index.php?accion=gato_eliminar" method="POST" class="d-inline form-eliminar"
                          data-nombre="<?php echo htmlspecialchars($gato['nombre']); ?>">
                      <input type="hidden" name="csrf" value="<?php echo Controller::tokenCsrf(); ?>">
                      <input type="hidden" name="id" value="<?php echo $gato['id']; ?>">
                      <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Eliminar</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
