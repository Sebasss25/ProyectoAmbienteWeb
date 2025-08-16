<?php
require_once __DIR__ . '/app/config/auth.php';
require_once __DIR__ . '/app/config/db.php';
require_once __DIR__ . '/app/models/Mascota.php';

start_session_safe();
if (empty($_SESSION['user_id'])) { header('Location: login.php'); exit; }

$rol = $_SESSION['rol'] ?? 'usuario';

if ($rol === 'admin' || $rol === 'voluntario') {
  require __DIR__ . '/dashboard_admin.php';
  exit;
}


$mModel = new Mascota();
$disponibles = $mModel->disponibles();

include 'app/views/partials/header.php';
?>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Mascotas disponibles</h2>
    <a href="reportes.php?action=create" class="btn btn-warning">
      <i class="fas fa-exclamation-triangle"></i> ¡Reportar un incidente!
    </a>
  </div>

  <?php if (!$disponibles): ?>
    <div class="alert alert-info">No hay mascotas disponibles por ahora.</div>
  <?php else: ?>
    <div class="row">
      <?php foreach ($disponibles as $m): ?>
        <div class="col-md-4 col-sm-12">
          <div class="card mb-3 h-100">
            <img src="<?= htmlspecialchars($m['foto'] ?: 'img/placeholder.jpg') ?>"
                 class="card-img-top imagen-mascota"
                 alt="Foto de <?= htmlspecialchars($m['nombre']) ?>"
                 loading="lazy"
                 onerror="this.onerror=null;this.src='img/placeholder.jpg';">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($m['nombre']) ?></h5>
              <p class="card-text">Raza: <?= htmlspecialchars($m['raza']) ?><br>Edad: <?= (int)$m['edad'] ?> años</p>
              <span class="badge badge-success">Disponible</span>
            </div>
            <div class="card-footer bg-white border-0">
              <a href="adopciones.php?action=create&mascota_id=<?= $m['id'] ?>" class="btn btn-success btn-sm">
                <i class="fas fa-heart"></i> Adoptar
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
<style>.imagen-mascota{width:100%;height:220px;object-fit:cover;background:#f3f5f7}</style>
<?php include 'app/views/partials/footer.php'; ?>
