<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Tareas de: <?= htmlspecialchars(($info['nombre'] ?? '').' '.($info['apellido'] ?? '')) ?></h3>
    <div>
      <a href="voluntarios.php" class="btn btn-secondary">Volver</a>
      <a href="voluntarios.php?action=tarea_create&id=<?= (int)$info['id_voluntario'] ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nueva tarea
      </a>
    </div>
  </div>

  <?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
  <?php endif; ?>
  <?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <div class="table-responsive">
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th>Título</th>
          <th>Estado</th>
          <th>Prioridad</th>
          <th>Asignada</th>
          <th>Fecha límite</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($tareas)): foreach ($tareas as $t): ?>
        <tr>
          <td><?= htmlspecialchars($t['titulo']) ?></td>
          <td>
            <?php
              $badge='badge-secondary';
              if ($t['estado']==='Pendiente') $badge='badge-warning';
              elseif ($t['estado']==='En progreso') $badge='badge-info';
              elseif ($t['estado']==='Completada') $badge='badge-success';
            ?>
            <span class="badge <?= $badge ?>"><?= htmlspecialchars($t['estado']) ?></span>
          </td>
          <td><span class="badge badge-dark"><?= htmlspecialchars($t['prioridad']) ?></span></td>
          <td><?= date('d/m/Y H:i', strtotime($t['fecha_asignacion'])) ?></td>
          <td><?= $t['fecha_limite'] ? date('d/m/Y H:i', strtotime($t['fecha_limite'])) : '-' ?></td>
          <td>
            <a class="btn btn-sm btn-warning" href="voluntarios.php?action=tarea_edit&id=<?= (int)$info['id_voluntario'] ?>&tarea_id=<?= (int)$t['id'] ?>">
              <i class="fas fa-edit"></i>
            </a>
            <a class="btn btn-sm btn-danger" href="voluntarios.php?action=tarea_delete&id=<?= (int)$info['id_voluntario'] ?>&tarea_id=<?= (int)$t['id'] ?>"
               onclick="return confirm('¿Eliminar tarea?')">
              <i class="fas fa-trash"></i>
            </a>
          </td>
        </tr>
        <?php if (!empty($t['descripcion'])): ?>
          <tr class="table-sm">
            <td colspan="6"><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($t['descripcion'])) ?></td>
          </tr>
        <?php endif; ?>
        <?php endforeach; else: ?>
        <tr><td colspan="6" class="text-center">No hay tareas asignadas</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
