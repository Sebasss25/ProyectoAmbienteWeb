<?php
require_once __DIR__ . '/app/config/auth.php';
require_once __DIR__ . '/app/models/eventos.php';
start_session_safe();



$eModel = new Evento();
$eventos = $eModel->disponibles();


include 'app/views/partials/header.php';
?>

<div class="container py-5">
  <h2 class="mb-4 text-center">Próximos Eventos</h2>

  <?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success'];
    unset($_SESSION['success']); ?></div>
  <?php endif; ?>

  <?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error'];
    unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <?php if (empty($eventos)): ?>
    <div class="alert alert-info">No hay eventos próximos por ahora.</div>
  <?php else: ?>
    <div class="row">
      <?php foreach ($eventos as $evento): ?>
        <div class="col-md-4 col-sm-6 mb-4">
          <div class="card h-100 shadow-sm">
            <img src="<?= htmlspecialchars($evento['imagen'] ?? 'img/eventos/default.jpg') ?>" class="card-img-top"
              alt="<?= htmlspecialchars($evento['nombre']) ?>" style="height: 200px; object-fit: cover;">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($evento['nombre']) ?></h5>
              <p class="card-text text-muted">
                <i class="fas fa-calendar-alt"></i>
                <?= date('d/m/Y H:i', strtotime($evento['fecha'])) ?>
              </p>
              <p class="card-text">
                <i class="fas fa-map-marker-alt"></i>
                <?= htmlspecialchars($evento['ubicacion']) ?>
              </p>
              <p class="card-text"><?= htmlspecialchars(substr($evento['descripcion'], 0, 100)) ?>...</p>
              <span class="badge bg-<?=
                $evento['estado'] === 'En curso' ? 'success' :
                ($evento['estado'] === 'Planificado' ? 'warning' : 'secondary')
                ?>">
                <?= htmlspecialchars($evento['estado']) ?>
              </span>
            </div>
            <div class="card-footer bg-white border-0">
              <a href="eventos.php?action=detalles&id=<?= $evento['id'] ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-info-circle"></i> Detalles
              </a>
              <?php if (isset($_SESSION['user_id']) && ($_SESSION['rol'] ?? 'usuario') === 'usuario'): ?>
                <?php if (in_array($evento['estado'], ['Planificado', 'En curso'])): ?>
                  <button class="btn btn-success btn-sm float-right" onclick="if(confirm('¿Confirmas tu asistencia a este evento?')) {
                        window.location.href='eventos.php?action=asistir&id=<?= $evento['id'] ?>';
                    }">
                    <i class="fas fa-calendar-check"></i> Asistir
                  </button>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php include 'app/views/partials/footer.php'; ?>