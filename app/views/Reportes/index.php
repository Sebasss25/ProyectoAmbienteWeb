<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-5">
  <div class="d-flex justify-content-between mb-3">
    <h3>Lista de Reportes</h3>
    <div>
      <a href="Reportes.php?action=create" class="btn btn-primary">Agregar Reporte</a>
    </div>
  </div>

  <?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
  <?php endif; ?>
  <?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <div class="card shadow-lg">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Usuario</th>
              <th>Provincia</th>
              <th>Cantón</th>
              <th>Distrito</th>
              <th>Detalles</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
          <?php if (!empty($reportes)): foreach ($reportes as $r): ?>
            <tr>
              <td><?= htmlspecialchars($r['fecha']) ?></td>
              <td><?= $r['usuario'] ? htmlspecialchars($r['usuario_nombre'] ?? ('ID '.$r['usuario'])) : 'Anónimo' ?></td>
              <td><?= htmlspecialchars($r['provincia']) ?></td>
              <td><?= htmlspecialchars($r['canton']) ?></td>
              <td><?= htmlspecialchars($r['distrito']) ?></td>
              <td class="text-wrap" style="white-space:normal; max-width:380px;"><?= nl2br(htmlspecialchars($r['detalles'])) ?></td>
              <td>
                <a href="Reportes.php?action=delete&id=<?= (int)$r['id'] ?>"
                   onclick="return confirm('¿Eliminar este reporte?')"
                   class="btn btn-danger btn-sm">
                  Eliminar
                </a>
              </td>
            </tr>
          <?php endforeach; else: ?>
            <tr><td colspan="7" class="text-center">No hay reportes</td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
