<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Lista de Voluntarios</h1>
    
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
      <a href="voluntarios.php?action=create" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Evento</a>
    <?php endif; ?>
  </div>

  <?php if (!empty($_SESSION['voluntarios_success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['voluntarios_success']; unset($_SESSION['voluntarios_success']); ?></div>
  <?php endif; ?>

  <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead class="thead-dark">
        <tr>
          <th>Usuario</th>
          <th>Fecha Inicio</th>
          <th>Fecha Fin</th>
          <th>Horas</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($voluntarios): foreach ($voluntarios as $v): ?>
        <tr>
          <td><?= htmlspecialchars($v['nombre']) ?></td>
          <td><?= date('d/m/Y H:i', strtotime($v['fechaInicio'])) ?></td>
          <td><?= date('d/m/Y H:i', strtotime($v['fechaFin'])) ?></td>
          <td><?= htmlspecialchars($v['horas']) ?></td>
          <td><?= htmlspecialchars($v['estado']) ?></td>
          <td>
            <?php if (($_SESSION['rol'] ?? 'usuario') === 'admin'): ?>
              <!-- <a href="voluntarios.php?action=edit&id=<?= $v['id'] ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
              </a> -->
              <a href="voluntarios.php?action=delete&id=<?= $v['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar voluntario?')">
                <i class="fas fa-trash"></i> Eliminar
              </a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="6" class="text-center">No hay Voluntarios registrados</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>