<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Nueva tarea para <?= htmlspecialchars(($info['nombre'] ?? '').' '.($info['apellido'] ?? '')) ?></h3>
    <a href="voluntarios.php?action=tareas&id=<?= (int)$info['id_voluntario'] ?>" class="btn btn-secondary">Volver</a>
  </div>

  <div class="card shadow">
    <div class="card-body">
      <form method="POST" action="">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" required>
          </div>
          <div class="form-group col-md-3">
            <label>Estado</label>
            <select name="estado" class="form-control">
              <option>Pendiente</option>
              <option>En progreso</option>
              <option>Completada</option>
            </select>
          </div>
          <div class="form-group col-md-3">
            <label>Prioridad</label>
            <select name="prioridad" class="form-control">
              <option>Media</option>
              <option>Alta</option>
              <option>Baja</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Descripción</label>
          <textarea name="descripcion" class="form-control" rows="3"></textarea>
        </div>

        <div class="form-group">
          <label>Fecha límite (opcional)</label>
          <input type="datetime-local" name="fecha_limite" class="form-control">
        </div>

        <button class="btn btn-primary">Guardar</button>
      </form>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
