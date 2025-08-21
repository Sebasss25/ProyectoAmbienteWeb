<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-5" style="max-width:720px;">
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

  <div class="card shadow-lg rounded-3">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h4 class="mb-0">Nuevo Reporte</h4>
      <?php if (($_SESSION['rol'] ?? '') === 'admin'): ?>
        <a class="btn btn-light btn-sm" href="Reportes.php">Ver reportes</a>
      <?php endif; ?>
    </div>

    <div class="card-body">
      <?php
        $nombreUsuario = 'Anónimo';
        if (!empty($_SESSION['user_id'])) {
          $nombreUsuario = htmlspecialchars(($_SESSION['nombre'] ?? 'Usuario') . (isset($_SESSION['apellido']) ? ' ' . $_SESSION['apellido'] : ''));
        }
      ?>
      <div class="alert alert-info py-2">
        Enviando como: <strong><?= $nombreUsuario ?></strong>
      </div>

      <form method="post" action="Reportes.php?action=create" autocomplete="off">
        <div class="mb-3">
          <label class="form-label">Fecha</label>
          <input type="datetime-local" name="fecha" class="form-control" required
                 value="<?= date('Y-m-d\TH:i') ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Provincia</label>
          <input type="text" name="provincia" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Cantón</label>
          <input type="text" name="canton" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Distrito</label>
          <input type="text" name="distrito" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Detalles</label>
          <textarea name="detalles" class="form-control" rows="4" required></textarea>
        </div>

        <div class="d-flex justify-content-between">
          <a href="<?= (($_SESSION['rol'] ?? '') === 'admin') ? 'Reportes.php' : 'index.php' ?>" class="btn btn-secondary">Cancelar</a>
          <button type="submit" class="btn btn-success">Enviar reporte</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
