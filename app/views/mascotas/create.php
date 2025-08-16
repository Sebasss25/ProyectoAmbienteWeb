<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Nueva Mascota</h1>
    <a href="mascotas.php" class="btn btn-secondary">Volver</a>
  </div>
  <div class="card shadow">
    <div class="card-body">
      <form action="mascotas.php?action=create" method="POST">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
          </div>
          <div class="form-group col-md-6">
            <label>Raza</label>
            <input type="text" name="raza" class="form-control" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label>Edad</label>
            <input type="number" name="edad" class="form-control" min="0" required>
          </div>
          <div class="form-group col-md-4">
            <label>Estado</label>
            <select name="estado" class="form-control" required>
              <option value="Disponible">Disponible</option>
              <option value="Adoptado">Adoptado</option>
              <option value="En comunicación">Adoptado</option>
              <option value="En tratamiento">Adoptado</option>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label>URL Foto (opcional)</label>
            <input type="text" name="foto" class="form-control">
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