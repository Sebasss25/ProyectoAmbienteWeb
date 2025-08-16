<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Lista de Eventos</h1>
    
    <form action="#" class="d-flex" role="search">
      <select class="form-select me-2" name="type">
        <option value="Sin Filtro">Sin Filtro</option>
        <option value="Presencial">Presencial</option>
        <option value="Virtual">Virtual</option>
      </select>
      <input class="form-control me-2" type="search" name="search" placeholder="Buscar por nombre o descripción">
      <button class="btn btn-secondary ml-2" type="submit">
        <i class="fas fa-search"></i> Buscar
      </button>
    </form>
    
    <?php if (($_SESSION['rol'] ?? 'usuario') === 'admin'): ?>
      <a href="eventos.php?action=create" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Evento</a>
    <?php endif; ?>
  </div>

  <?php if (!empty($_SESSION['eventos_success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['eventos_success']; unset($_SESSION['eventos_success']); ?></div>
  <?php endif; ?>

  <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead class="thead-dark">
        <tr>
          <th>Nombre</th>
          <th>Fecha</th>
          <th>Ubicación</th>
          <th>Tipo</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($eventos): foreach ($eventos as $e): ?>
        <tr>
          <td><?= htmlspecialchars($e['nombre']) ?></td>
          <td><?= date('d/m/Y H:i', strtotime($e['fecha'])) ?></td>
          <td><?= htmlspecialchars($e['ubicacion']) ?></td>
          <td><?= htmlspecialchars($e['tipo']) ?></td>
          <td>
            <span class="badge badge-<?= ($e['estado']=='En curso') ? 'success' : (($e['estado']=='Planificado') ? 'warning' : 'secondary') ?>">
              <?= $e['estado'] ?>
            </span>
          </td>
          <td>
            <a href="eventos.php?action=detalles&id=<?= $e['id'] ?>" class="btn btn-info btn-sm">
              <i class="fas fa-eye"></i> Detalles
            </a>
            <?php if (($_SESSION['rol'] ?? 'usuario') === 'admin'): ?>
              <a href="eventos.php?action=edit&id=<?= $e['id'] ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
              </a>
              <a href="eventos.php?action=delete&id=<?= $e['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar evento?')">
                <i class="fas fa-trash"></i> Eliminar
              </a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="6" class="text-center">No hay eventos registrados</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>