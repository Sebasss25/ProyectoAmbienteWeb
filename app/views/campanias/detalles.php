<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4" style="max-width: 960px;">
  <div class="card shadow-sm">
    <div class="card-header text-white" style="background:#14b8d4;">
      <strong>Detalles de Campaña</strong>
    </div>

    <div class="card-body p-0">
      <table class="table mb-0">
        <tbody>
          <tr>
            <th class="w-25 text-muted">Nombre:</th>
            <td><?= htmlspecialchars($campania['nombre']) ?></td>
          </tr>
          <tr>
            <th class="text-muted">Fecha Inicio:</th>
            <td><?= date('d/m/Y H:i', strtotime($campania['fechaInicio'])) ?></td>
          </tr>
          <tr>
            <th class="text-muted">Fecha Fin:</th>
            <td><?= date('d/m/Y H:i', strtotime($campania['fechaFin'])) ?></td>
          </tr>
          <tr>
            <th class="text-muted">Objetivo:</th>
            <td>$<?= number_format($campania['objetivo'], 2) ?></td>
          </tr>
          <tr>
            <th class="text-muted">Estado:</th>
            <td>
              <span class="badge <?= ($campania['estado'] === 'Activa' ? 'badge-success' : 'badge-secondary') ?>">
                <?= htmlspecialchars($campania['estado']) ?>
              </span>
            </td>
          </tr>
          <tr>
            <th class="align-top text-muted">Descripción:</th>
            <td><?= nl2br(htmlspecialchars($campania['descripcion'])) ?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="card-footer bg-white">
      <?php if (($_SESSION['rol'] ?? 'usuario') === 'admin' || ($_SESSION['rol'] ?? '') === 'voluntario'): ?>
      <?php else: ?>
        <?php if ($campania['estado'] === 'Activa'): ?>
          <a href="campanias.php?action=donar&id=<?= $campania['id'] ?>" class="btn btn-success">
            <i class="fas fa-hand-holding-heart"></i> Donar
          </a>
        <?php endif; ?>
        <a href="campanias.php" class="btn btn-secondary ml-2">Volver</a>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>