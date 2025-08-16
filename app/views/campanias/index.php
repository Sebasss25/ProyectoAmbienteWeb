<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Lista de Campañas</h1>

    <form class="d-flex" role="search">
      <input class="form-control me-2" type="search" name="search" placeholder="Buscar por nombre o descripción">
      <button class="btn btn-secondary ml-2" type="submit">
        <i class="fas fa-search"></i> Buscar
      </button>
    </form>

    <?php if (($_SESSION['rol'] ?? 'usuario') === 'admin'): ?>
      <a href="campanias.php?action=create" class="btn btn-primary"><i class="fas fa-plus"></i> Nueva Campaña</a>
    <?php endif; ?>
  </div>

  <?php if (!empty($_SESSION['campanias_success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['campanias_success'];
    unset($_SESSION['campanias_success']); ?></div>
  <?php endif; ?>

  <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead class="thead-dark">
        <tr>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Fecha Inicio</th>
          <th>Fecha Fin</th>
          <th>Objetivo</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($campanias):
          foreach ($campanias as $c): ?>
            <tr>
              <td><?= htmlspecialchars($c['nombre']) ?></td>
              <td><?= htmlspecialchars(substr($c['descripcion'], 0, 50)) ?>...</td>
              <td><?= date('d/m/Y', strtotime($c['fechaInicio'])) ?></td>
              <td><?= date('d/m/Y', strtotime($c['fechaFin'])) ?></td>
              <td>$<?= number_format($c['objetivo'], 2) ?></td>
              <td>
                <span class="badge badge-<?= $c['estado'] === 'Activa' ? 'success' : 'secondary' ?>">
                  <?= $c['estado'] ?>
                </span>
              </td>
              <td>
                <a href="campanias.php?action=detalles&id=<?= $c['id'] ?>" class="btn btn-info btn-sm">
                  <i class="fas fa-eye"></i> Detalles
                </a>
                <?php if (($_SESSION['rol'] ?? 'usuario') === 'admin'): ?>
                  <a href="campanias.php?action=edit&id=<?= $c['id'] ?>" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Editar
                  </a>
                  <a href="campanias.php?action=delete&id=<?= $c['id'] ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('¿Eliminar campaña?')">
                    <i class="fas fa-trash"></i> Eliminar
                  </a>
                  <a href="campanias.php?action=verDonaciones" class="btn btn-info">
                    <i class="fas fa-hand-holding-usd"></i> Ver Donaciones
                  </a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; else: ?>
          <tr>
            <td colspan="7" class="text-center">No hay campañas registradas</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>