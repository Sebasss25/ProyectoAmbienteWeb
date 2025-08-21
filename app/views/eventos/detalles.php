<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4" style="max-width: 960px;">
  <div class="card shadow-sm">
    <div class="card-header text-white" style="background:#14b8d4;">
      <strong>Detalles del Evento</strong>
    </div>

    <div class="card-body p-0">
      <table class="table mb-0">
        <tbody>
          <tr>
            <th class="w-25 text-muted">Nombre:</th>
            <td><?= htmlspecialchars($e['nombre']) ?></td>
          </tr>
          <tr>
            <th class="text-muted">Fecha:</th>
            <td><?= date('d/m/Y H:i', strtotime($e['fecha'])) ?></td>
          </tr>
          <tr>
            <th class="text-muted">Ubicación:</th>
            <td><?= htmlspecialchars($e['ubicacion']) ?></td>
          </tr>
          <tr>
            <th class="text-muted">Tipo:</th>
            <td>
              <span class="badge badge-<?= ($e['tipo'] === 'Virtual' ? 'info' : 'primary') ?>">
                <?= htmlspecialchars($e['tipo']) ?>
              </span>
            </td>
          </tr>
          <tr>
            <th class="text-muted">Estado:</th>
            <td>
              <span class="badge <?= ($e['estado'] == 'En curso') ? 'badge-success' : (($e['estado'] == 'Planificado') ? 'badge-warning' : 'badge-secondary') ?>">
                <?= htmlspecialchars($e['estado']) ?>
              </span>
            </td>
          </tr>
          <tr>
            <th class="align-top text-muted">Descripción:</th>
            <td><?= nl2br(htmlspecialchars($e['descripcion'])) ?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="card-footer bg-white">
      <?php
        $rol    = $_SESSION['rol']     ?? 'usuario';
        $userId = $_SESSION['user_id'] ?? null;
      ?>

      <?php if (in_array($rol, ['admin','voluntario'], true)): ?>
        <a href="eventos.php" class="btn btn-secondary">Volver</a>

      <?php else: ?>
        <?php if (in_array($e['estado'], ['Planificado', 'En curso'], true)): ?>
          <?php if ($userId): ?>
            <?php
              require_once __DIR__ . '/../../models/EventoAsistencia.php';
              $asistenciaModel = new EventoAsistencia();
              $yaAsistio = $asistenciaModel->verificarAsistencia((int)$e['id'], (int)$userId);
            ?>

            <?php if ($yaAsistio): ?>
              <button class="btn btn-success" disabled>
                <i class="fas fa-check-circle"></i> Ya estás registrado
              </button>
            <?php else: ?>
              <button
                class="btn btn-success"
                onclick="if(confirm('¿Confirmas tu asistencia a este evento?')) { window.location.href='eventos.php?action=asistir&id=<?= (int)$e['id'] ?>'; }">
                <i class="fas fa-calendar-check"></i> Asistir
              </button>
            <?php endif; ?>

          <?php else: ?>
            <button
              class="btn btn-success"
              onclick="window.location.href='eventos.php?action=asistir&id=<?= (int)$e['id'] ?>'">
              <i class="fas fa-calendar-check"></i> Asistir
            </button>
          <?php endif; ?>
        <?php endif; ?>

        <a href="eventos.php" class="btn btn-secondary ml-2">Volver</a>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
