<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Editar tarea</h3>
    <a href="voluntarios.php?action=tareas&id=<?= (int)$_GET['id'] ?>" class="btn btn-secondary">Volver</a>
  </div>

  <div class="card shadow">
    <div class="card-body">
      <form method="POST" action="">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($tarea['titulo'] ?? '') ?>" required>
          </div>
          <div class="form-group col-md-3">
            <label>Estado</label>
            <select name="estado" class="form-control">
              <?php $estado = $tarea['estado'] ?? 'Pendiente'; ?>
              <option <?= $estado==='Pendiente'?'selected':'' ?>>Pendiente</option>
              <option <?= $estado==='En progreso'?'selected':'' ?>>En progreso</option>
              <option <?= $estado==='Completada'?'selected':'' ?>>Completada</option>
            </select>
          </div>
          <div class="form-group col-md-3">
            <label>Prioridad</label>
            <?php $prior = $tarea['prioridad'] ?? 'Media'; ?>
            <select name="prioridad" class="form-control">
              <option <?= $prior==='Media'?'selected':'' ?>>Media</option>
              <option <?= $prior==='Alta'?'selected':'' ?>>Alta</option>
              <option <?= $prior==='Baja'?'selected':'' ?>>Baja</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Descripción</label>
          <textarea name="descripcion" class="form-control" rows="3"><?= htmlspecialchars($tarea['descripcion'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
          <label>Fecha límite (opcional)</label>
          <input type="datetime-local" name="fecha_limite"
                 value="<?= !empty($tarea['fecha_limite']) ? date('Y-m-d\TH:i', strtotime($tarea['fecha_limite'])) : '' ?>"
                 class="form-control">
        </div>

        <button class="btn btn-primary">Actualizar</button>
      </form>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
