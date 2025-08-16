<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Editar Evento</h1>
    <a href="eventos.php" class="btn btn-secondary">Volver</a>
  </div>
  
  <div class="card shadow">
    <div class="card-body">
      <form action="eventos.php?action=edit&id=<?= $evento['id'] ?>" method="POST">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($evento['nombre']) ?>" required>
          </div>
          <div class="form-group col-md-6">
            <label>Fecha y Hora</label>
            <input type="datetime-local" name="fecha" class="form-control" 
                   value="<?= date('Y-m-d\TH:i', strtotime($evento['fecha'])) ?>" required>
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group col-md-4">
            <label>Ubicación</label>
            <input type="text" name="ubicacion" class="form-control" 
                   value="<?= htmlspecialchars($evento['ubicacion']) ?>" required>
          </div>
          <div class="form-group col-md-4">
            <label>Tipo</label>
            <select name="tipo" class="form-control" required>
              <option value="Presencial" <?= $evento['tipo']==='Presencial'?'selected':'' ?>>Presencial</option>
              <option value="Virtual" <?= $evento['tipo']==='Virtual'?'selected':'' ?>>Virtual</option>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label>Estado</label>
            <select name="estado" class="form-control" required>
              <option value="Planificado" <?= $evento['estado']==='Planificado'?'selected':'' ?>>Planificado</option>
              <option value="En curso" <?= $evento['estado']==='En curso'?'selected':'' ?>>En curso</option>
              <option value="Finalizado" <?= $evento['estado']==='Finalizado'?'selected':'' ?>>Finalizado</option>
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <label>Descripción</label>
          <textarea name="descripcion" class="form-control" rows="4" required><?= htmlspecialchars($evento['descripcion']) ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Actualizar</button>
      </form>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>