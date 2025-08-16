<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Editar Campaña</h1>
    <a href="campanias.php" class="btn btn-secondary">Volver</a>
  </div>
  
  <div class="card shadow">
    <div class="card-body">
      <form action="campanias.php?action=edit&id=<?= $campania['id'] ?>" method="POST">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($campania['nombre']) ?>" required>
          </div>
          <div class="form-group col-md-6">
            <label>Objetivo ($)</label>
            <input type="number" name="objetivo" class="form-control" value="<?= $campania['objetivo'] ?>" min="0" step="0.01" required>
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group col-md-4">
            <label>Fecha Inicio</label>
            <input type="datetime-local" name="fechaInicio" class="form-control" 
                   value="<?= date('Y-m-d\TH:i', strtotime($campania['fechaInicio'])) ?>" required>
          </div>
          <div class="form-group col-md-4">
            <label>Fecha Fin</label>
            <input type="datetime-local" name="fechaFin" class="form-control" 
                   value="<?= date('Y-m-d\TH:i', strtotime($campania['fechaFin'])) ?>" required>
          </div>
          <div class="form-group col-md-4">
            <label>Estado</label>
            <select name="estado" class="form-control" required>
              <option value="Activa" <?= $campania['estado']==='Activa'?'selected':'' ?>>Activa</option>
              <option value="Inactiva" <?= $campania['estado']==='Inactiva'?'selected':'' ?>>Inactiva</option>
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <label>Descripción</label>
          <textarea name="descripcion" class="form-control" rows="4" required><?= htmlspecialchars($campania['descripcion']) ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Actualizar</button>
      </form>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>