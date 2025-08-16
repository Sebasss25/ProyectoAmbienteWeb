<?php
require_once __DIR__ . '/app/config/auth.php';
require_once __DIR__ . '/app/models/Campania.php';
start_session_safe();

$cModel = new Campania();
$campanias = $cModel->activas();

include 'app/views/partials/header.php';
?>

<div class="container py-5">
  <h2 class="mb-4 text-center">Campañas activas</h2>

  <?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>
  
  <?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <?php if (empty($campanias)): ?>
    <div class="alert alert-info">No hay campañas activas por ahora.</div>
  <?php else: ?>
    <div class="row">
      <?php foreach ($campanias as $campania): ?>
        <div class="col-md-4 col-sm-6 mb-4">
          <div class="card h-100 shadow-sm">
            <img src="<?= htmlspecialchars($campania['imagen'] ?? 'https://static3.teletica.com/Files/Sizes/2023/10/12/campaa-huellitas-chira.-fotografas-adriana-araya_1597241119_380x260.jpg') ?>" 
                 class="card-img-top img-fluid" 
                 alt="<?= htmlspecialchars($campania['nombre']) ?>"
                 style="height: 200px; object-fit: cover;">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($campania['nombre']) ?></h5>
              <p class="card-text text-muted">
                <small>
                  <i class="fas fa-calendar-alt"></i> 
                  <?= date('d/m/Y', strtotime($campania['fechaInicio'])) ?> - 
                  <?= date('d/m/Y', strtotime($campania['fechaFin'])) ?>
                </small>
              </p>
              <p class="card-text"><?= htmlspecialchars(substr($campania['descripcion'], 0, 100)) ?>...</p>
              <div class="d-flex justify-content-between align-items-center">
                <span class="badge bg-<?= $campania['estado'] === 'Activa' ? 'success' : 'secondary' ?>">
                  <?= htmlspecialchars($campania['estado']) ?>
                </span>
                <span class="text-primary fw-bold">$<?= number_format($campania['objetivo'], 2) ?></span>
              </div>
            </div>
            <div class="card-footer bg-white border-0 d-flex justify-content-between">
              <a href="campanias.php?action=detalles&id=<?= $campania['id'] ?>" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-info-circle"></i> Detalles
              </a>
              <?php if (isset($_SESSION['user_id']) && ($_SESSION['rol'] ?? 'usuario') === 'usuario'): ?>
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#donacionModal<?= $campania['id'] ?>">
                  <i class="fas fa-hand-holding-heart"></i> Donar
                </button>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php include 'app/views/partials/footer.php'; ?>