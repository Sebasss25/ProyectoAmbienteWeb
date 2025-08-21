<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Activar voluntariado</h3>
    <a href="voluntarios.php" class="btn btn-secondary">Volver</a>
  </div>

  <?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <div class="card shadow">
    <div class="card-body">
      <p class="mb-3">Selecciona un usuario con rol <strong>Voluntario</strong> para activarlo:</p>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="thead-light">
            <tr>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($candidatos)): foreach ($candidatos as $u): ?>
              <tr>
                <td><?= htmlspecialchars($u['nombre'].' '.$u['apellido']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td>
                  <a class="btn btn-primary btn-sm" href="voluntarios.php?action=activar&id=<?= (int)$u['id'] ?>"
                     onclick="return confirm('¿Activar voluntariado para <?= htmlspecialchars($u['nombre']) ?>?')">
                    <i class="fas fa-user-check"></i> Activar
                  </a>
                </td>
              </tr>
            <?php endforeach; else: ?>
              <tr><td colspan="3" class="text-center">No hay candidatos disponibles (todos los voluntarios ya están activos).</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
