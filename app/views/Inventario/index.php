<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Inventario</h1>

    <?php if (($_SESSION['rol'] ?? 'usuario') === 'admin'): ?>
      <a href="Inventario.php?action=create" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</a>
    <?php endif; ?>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead class="thead-dark">
        <tr>
          <th>Nombre</th>
          <th>Tipo</th>
          <th>Cantidad</th>
          <th>Fecha Ingreso</th>
          <th>Fecha Caducidad</th>
          <th>Proveedor</th>
          <th>Fuente</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($items): foreach ($items as $i): ?>
          <tr>
            <td><?= htmlspecialchars($i['nombre']) ?></td>
            <td><?= htmlspecialchars($i['tipo']) ?></td>
            <td><?= htmlspecialchars($i['cantidad']) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($i['fechaIngreso'])) ?></td>
            <td><?= $i['fechaCaducidad'] ? date('d/m/Y H:i', strtotime($i['fechaCaducidad'])) : 'N/A' ?></td>
            <td><?= htmlspecialchars($i['proveedor']) ?></td>
            <td><?= htmlspecialchars($i['fuente']) ?></td>
            <td>
              <a href="inventario.php?action=delete&id=<?= $i['id'] ?>" 
                 class="btn btn-danger btn-sm"
                 onclick="return confirm('¿Eliminar ítem?')">
                 <i class="fas fa-trash"></i> Eliminar
              </a>
            </td>
          </tr>
        <?php endforeach; else: ?>
          <tr><td colspan="8" class="text-center">No hay ítems registrados</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
