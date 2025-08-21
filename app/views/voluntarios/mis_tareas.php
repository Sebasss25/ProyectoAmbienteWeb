<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Mis tareas de voluntariado</h3>
    <a href="voluntarios.php" class="btn btn-secondary">Volver</a>
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
          <th>Descripción</th>
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
          <td class="text-wrap" style="white-space:normal;max-width:420px;">
            <?= nl2br(htmlspecialchars($t['descripcion'])) ?>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="6" class="text-center">No tienes tareas asignadas</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
