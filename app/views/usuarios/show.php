<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4" style="max-width: 860px;">
  <div class="card shadow-sm">
    <div class="card-header text-white" style="background:#14b8d4;">
      <strong>Detalles de Usuario</strong>
    </div>

    <div class="card-body p-0">
      <table class="table mb-0">
        <tbody>
          <tr>
            <th class="w-25 text-muted">Nombre:</th>
            <td><?= htmlspecialchars($usuario['nombre']) ?></td>
          </tr>
          <tr>
            <th class="text-muted">Apellido:</th>
            <td><?= htmlspecialchars($usuario['apellido']) ?></td>
          </tr>
          <tr>
            <th class="text-muted">Email:</th>
            <td><?= htmlspecialchars($usuario['email']) ?></td>
          </tr>
          <tr>
            <th class="text-muted">Teléfono:</th>
            <td><?= htmlspecialchars($usuario['telefono']) ?></td>
          </tr>
          <tr>
            <th class="text-muted">Rol:</th>
            <td>
              <?php $badge = 'badge-secondary';
                if (($usuario['rol_nombre'] ?? '') === 'Administrador') $badge='badge-dark';
                elseif (($usuario['rol_nombre'] ?? '') === 'Voluntario') $badge='badge-info';
                elseif (($usuario['rol_nombre'] ?? '') === 'Usuario') $badge='badge-success';
              ?>
              <span class="badge <?= $badge ?>"><?= htmlspecialchars($usuario['rol_nombre'] ?? $usuario['rol']) ?></span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="card-footer bg-white">
      <a href="usuarios.php" class="btn btn-secondary">Volver</a>
      <?php if (($_SESSION['rol'] ?? 'usuario') === 'admin'): ?>
        <a href="usuarios.php?action=edit&id=<?= (int)$usuario['id'] ?>" class="btn btn-warning ml-2">Editar</a>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
