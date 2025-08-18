<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Editar Usuario</h1>
    <a href="usuarios.php" class="btn btn-secondary">Volver</a>
  </div>
  
  <div class="card shadow">
    <div class="card-body">
      <form action="usuarios.php?action=edit&id=<?= $usuario['id'] ?>" method="POST">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
          </div>
          <div class="form-group col-md-6">
            <label>Apellido</label>
            <input type="text" name="apellido" class="form-control" value="<?= htmlspecialchars($usuario['apellido']) ?>" required>
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group col-md-4">
            <label>Email</label>
            <input type="text" name="email" class="form-control" 
                   value="<?= htmlspecialchars($usuario['email']) ?>" required>
          </div>
          <div class="form-group col-md-4">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($usuario['telefono']) ?>" required>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label>Rol</label>
          </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Actualizar</button>
      </form>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>