<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Lista de Voluntarios</h1>

    <div class="d-flex align-items-center">
      <?php if (($_SESSION['rol'] ?? '') === 'voluntario'): ?>
        <a href="voluntarios.php?action=mis_tareas" class="btn btn-info mr-2">
          <i class="fas fa-tasks"></i> Mis tareas
        </a>
      <?php endif; ?>

      <?php if (($_SESSION['rol'] ?? '') === 'admin'): ?>
        <a href="voluntarios.php?action=activar_select" class="btn btn-primary mr-3">
          <i class="fas fa-user-plus"></i> Activar voluntariado
        </a>
      <?php endif; ?>

      <form action="voluntarios.php" method="get" class="d-flex mb-0" role="search">
        <input type="hidden" name="action" value="search">
        <input class="form-control me-2" type="search" name="estado" placeholder="Buscar por estado">
        <button class="btn btn-secondary ml-2" type="submit">
          <i class="fas fa-search"></i> Buscar
        </button>
      </form>
    </div>
  </div>

  <?php if (!empty($_SESSION['voluntarios_success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['voluntarios_success']); unset($_SESSION['voluntarios_success']); ?></div>
  <?php endif; ?>
  <?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
  <?php endif; ?>
  <?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
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
        <?php if (!empty($voluntarios)): foreach ($voluntarios as $v): ?>
          <tr>
            <td><?= htmlspecialchars(($v['nombre'] ?? '').' '.($v['apellido'] ?? '')) ?></td>
            <td><?= !empty($v['fechaInicio']) ? date('d/m/Y H:i', strtotime($v['fechaInicio'])) : '-' ?></td>
            <td><?= !empty($v['fechaFin']) ? date('d/m/Y H:i', strtotime($v['fechaFin'])) : '-' ?></td>
            <td><?= htmlspecialchars($v['horas'] ?? '0') ?></td>
            <td>
              <?php $badge = ($v['estado']==='Activo') ? 'badge-success' : 'badge-secondary'; ?>
              <span class="badge <?= $badge ?>"><?= htmlspecialchars($v['estado']) ?></span>
            </td>
            <td>
              <?php if (($_SESSION['rol'] ?? 'usuario') === 'admin'): ?>
                <a href="voluntarios.php?action=tareas&id=<?= (int)$v['id_voluntario'] ?>" class="btn btn-info btn-sm">
                  <i class="fas fa-tasks"></i> Tareas
                </a>
                <?php if ($v['estado']==='Activo'): ?>
                  <a href="voluntarios.php?action=inactivar&id=<?= (int)$v['id_voluntario'] ?>" class="btn btn-warning btn-sm" onclick="return confirm('¿Finalizar voluntariado?')">
                    <i class="fas fa-user-slash"></i> Finalizar
                  </a>
                <?php endif; ?>
                <a href="voluntarios.php?action=delete&id=<?= (int)$v['id_voluntario'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar voluntario?')">
                  <i class="fas fa-trash"></i> Eliminar
                </a>
              <?php else: ?>
                <span class="text-muted">-</span>
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
