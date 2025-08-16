<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Nueva Campaña</h1>
    <a href="campanias.php" class="btn btn-secondary">Volver</a>
  </div>
  
  <div class="card shadow">
    <div class="card-body">
      <form action="campanias.php?action=create" method="POST">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
          </div>
          <div class="form-group col-md-6">
            <label>Objetivo ($)</label>
            <input type="number" name="objetivo" class="form-control" min="0" step="0.01" required>
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group col-md-4">
            <label>Fecha Inicio</label>
            <input type="datetime-local" name="fechaInicio" class="form-control" required>
          </div>
          <div class="form-group col-md-4">
            <label>Fecha Fin</label>
            <input type="datetime-local" name="fechaFin" class="form-control" required>
          </div>
          <div class="form-group col-md-4">
            <label>Estado</label>
            <select name="estado" class="form-control" required>
              <option value="Activa">Activa</option>
              <option value="Inactiva">Inactiva</option>
            </select>
          </div>
        </div>
        
        <div class="form-group">
          <label>Descripción</label>
          <textarea name="descripcion" class="form-control" rows="4" required></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar</button>
      </form>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>