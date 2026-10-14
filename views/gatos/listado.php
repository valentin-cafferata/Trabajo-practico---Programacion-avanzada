<?php
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
        <h2 class="fw-bold mb-0">Gatos publicados</h2>
        <a href="index.php?accion=gato_nuevo" class="btn btn-primary">+ Nuevo gato</a>
      </div>

      <div class="table-responsive">
        <table id="tabla-gatos" class="table table-striped table-hover align-middle w-100">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Raza</th>
              <th>Edad</th>
              <th>Sexo</th>
              <th>Precio</th>
              <th>Descripción</th>
              <th class="text-end">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($gatos as $gato): ?>
              <tr>
                <td><?php echo $gato['id']; ?></td>
                <td class="fw-semibold"><?php echo htmlspecialchars($gato['nombre']); ?></td>
                <td><?php echo htmlspecialchars($gato['raza']); ?></td>
                <td class="text-nowrap" data-order="<?php echo $gato['edad']; ?>"><?php echo $gato['edad']; ?> año(s)</td>
                <td><?php echo $gato['sexo']; ?></td>
                <td class="text-nowrap" data-order="<?php echo $gato['precio']; ?>">$ <?php echo number_format($gato['precio'], 2, ',', '.'); ?></td>
                <td class="text-muted small"><?php echo htmlspecialchars($gato['descripcion'] ?? ''); ?></td>
                <td class="text-end text-nowrap">
                  <a href="index.php?accion=gato_editar&amp;id=<?php echo $gato['id']; ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
                  <form action="index.php?accion=gato_eliminar" method="POST" class="d-inline form-eliminar"
                        data-nombre="<?php echo htmlspecialchars($gato['nombre']); ?>">
                    <input type="hidden" name="csrf" value="<?php echo Controller::tokenCsrf(); ?>">
                    <input type="hidden" name="id" value="<?php echo $gato['id']; ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
