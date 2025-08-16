<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Editar Mascota</h1>
    <a href="mascotas.php" class="btn btn-secondary">Volver</a>
  </div>
  <div class="card shadow">
    <div class="card-body">
      <form action="mascotas.php?action=edit&id=<?= $mascota['id'] ?>" method="POST">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($mascota['nombre']) ?>" required>
          </div>
          <div class="form-group col-md-6">
            <label>Raza</label>
            <input type="text" name="raza" class="form-control" value="<?= htmlspecialchars($mascota['raza']) ?>" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label>Edad</label>
            <input type="number" name="edad" class="form-control" value="<?= (int)$mascota['edad'] ?>" required>
          </div>
          <div class="form-group col-md-4">
            <label>Estado</label>
            <select name="estado" class="form-control" required>
              <option value="Disponible" <?= $mascota['estado']==='Disponible'?'selected':'' ?>>Disponible</option>
              <option value="Adoptado" <?= $mascota['estado']==='Adoptado'?'selected':'' ?>>Adoptado</option>
              <option value="En comunicación" <?= $mascota['estado']==='En comunicación'?'selected':'' ?>>En comunicación</option>
              <option value="En tratamiento" <?= $mascota['estado']==='En tratamiento'?'selected':'' ?>>En tratamiento</option>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label>URL Foto</label>
            <input type="text" name="foto" class="form-control" value="<?= htmlspecialchars($mascota['foto']) ?>">
          </div>
        </div>
        <div class="form-group">
          <label>Descripción</label>
          <textarea name="descripcion" class="form-control" rows="4" required><?= htmlspecialchars($mascota['descripcion']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
      </form>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>