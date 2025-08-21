<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Lista de Usuarios</h1>

    <form action="usuarios.php" method="get" class="d-flex" role="search">
      <input type="hidden" name="action" value="search">
      <input class="form-control me-2" type="search" name="email" placeholder="Buscar por correo">
      <button class="btn btn-secondary ml-2" type="submit">
        <i class="fas fa-search"></i> Buscar
      </button>
    </form>
  </div>

  <?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success">
      <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
    </div>
  <?php endif; ?>
  <?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger">
      <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
    </div>
  <?php endif; ?>

  <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead class="thead-dark">
        <tr>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Email</th>
          <th>Teléfono</th>
          <th>Rol</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($usuarios)): foreach ($usuarios as $u): ?>
          <tr>
            <td><?= htmlspecialchars($u['nombre']) ?></td>
            <td><?= htmlspecialchars($u['apellido']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars($u['telefono']) ?></td>
            <td><?= htmlspecialchars($u['rol_nombre'] ?? $u['rol']) ?></td>
            <td>
              <a href="usuarios.php?action=show&id=<?= (int)$u['id'] ?>" class="btn btn-info btn-sm">
                <i class="fas fa-eye"></i> Ver
              </a>
              <?php if (($_SESSION['rol'] ?? 'usuario') === 'admin'): ?>
                <a href="usuarios.php?action=edit&id=<?= (int)$u['id'] ?>" class="btn btn-warning btn-sm">
                  <i class="fas fa-edit"></i> Editar
                </a>
                <a href="usuarios.php?action=delete&id=<?= (int)$u['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar usuario?')">
                  <i class="fas fa-trash"></i> Eliminar
                </a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; else: ?>
          <tr><td colspan="6" class="text-center">No hay Usuarios registrados</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
