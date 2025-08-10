<?php
require_once __DIR__ . '/app/config/auth.php';
require_once __DIR__ . '/app/config/db.php';
start_session_safe();
if (empty($_SESSION['user_id'])) { header('Location: login.php'); exit; }

$db = Database::connect();

function db_count(mysqli $db, string $sql): int {
  $res = $db->query($sql);
  if (!$res) return 0;
  $row = $res->fetch_assoc();
  return isset($row['c']) ? (int)$row['c'] : 0;
}

$totMascotas       = db_count($db, "SELECT COUNT(*) c FROM Mascotas");
$totDisponibles    = db_count($db, "SELECT COUNT(*) c FROM Mascotas WHERE estado = 'Disponible'");
$totAdoptadas      = db_count($db, "SELECT COUNT(*) c FROM Mascotas WHERE estado = 'Adoptado'");
$totAdopciones     = db_count($db, "SELECT COUNT(*) c FROM Adopciones");
$totCampanias      = db_count($db, "SELECT COUNT(*) c FROM Campanias");
$totReportes       = db_count($db, "SELECT COUNT(*) c FROM Reportes");

$mascotasRec = $db->query("SELECT id,nombre,raza,estado FROM Mascotas ORDER BY id DESC LIMIT 5");
$adopRec     = $db->query("SELECT A.id, A.fecha, U.nombre AS usuario, M.nombre AS mascota
                           FROM Adopciones A 
                           JOIN Usuarios U ON U.id=A.usuario
                           JOIN Mascotas M ON M.id=A.mascota
                           ORDER BY A.id DESC LIMIT 5");

include __DIR__ . '/app/views/partials/header.php';
?>
<div class="container py-4">
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
      <h2 class="mb-1">Panel de <?= htmlspecialchars($_SESSION['nombre']) ?></h2>
      <p class="text-muted mb-0">Resumen y accesos de gestión.</p>
    </div>
  </div>

  <div class="row text-center g-3 mb-4">
    <div class="col-md-3 mb-3">
      <div class="card shadow-sm border-0 h-100"><div class="card-body">
        <div class="display-4 mb-1"><?= $totMascotas ?></div>
        <div class="text-muted">Total de Mascotas</div>
      </div></div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card shadow-sm border-0 h-100"><div class="card-body">
        <div class="display-4 mb-1"><?= $totDisponibles ?></div>
        <div class="text-muted">Mascotas Disponibles</div>
      </div></div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card shadow-sm border-0 h-100"><div class="card-body">
        <div class="display-4 mb-1"><?= $totAdoptadas ?></div>
        <div class="text-muted">Mascotas Adoptadas</div>
      </div></div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card shadow-sm border-0 h-100"><div class="card-body">
        <div class="display-4 mb-1"><?= $totAdopciones ?></div>
        <div class="text-muted">Solicitudes de adopciones</div>
      </div></div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card shadow-sm border-0 h-100"><div class="card-body">
        <div class="display-4 mb-1"><?= $totCampanias ?></div>
        <div class="text-muted">Campañas</div>
      </div></div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card shadow-sm border-0 h-100"><div class="card-body">
        <div class="display-4 mb-1"><?= $totReportes ?></div>
        <div class="text-muted">Reportes</div>
      </div></div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6 mb-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-header bg-white border-0">
          <strong><i class="fas fa-paw"></i> Mascotas recientes</strong>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table mb-0">
              <thead class="thead-light">
                <tr><th>Nombre</th><th>Raza</th><th>Estado</th></tr>
              </thead>
              <tbody>
                <?php if ($mascotasRec && $mascotasRec->num_rows): while($r=$mascotasRec->fetch_assoc()): ?>
                  <tr>
                    <td><?= htmlspecialchars($r['nombre']) ?></td>
                    <td><?= htmlspecialchars($r['raza']) ?></td>
                    <td>
                      <span class="badge <?= $r['estado']==='Disponible' ? 'badge-success' : 'badge-secondary' ?>">
                        <?= htmlspecialchars($r['estado']) ?>
                      </span>
                    </td>
                  </tr>
                <?php endwhile; else: ?>
                  <tr><td colspan="3" class="text-center text-muted">Sin registros aún</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer bg-white border-0 text-right">
          <a href="mascotas.php" class="btn btn-sm btn-primary">Ir a Mascotas</a>
        </div>
      </div>
    </div>

    <div class="col-lg-6 mb-4">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-header bg-white border-0">
          <strong><i class="fas fa-heart"></i> Solicitudes de adopciones recientes</strong>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table mb-0">
              <thead class="thead-light">
                <tr><th>Fecha</th><th>Usuario</th><th>Mascota</th></tr>
              </thead>
              <tbody>
                <?php if ($adopRec && $adopRec->num_rows): while($a=$adopRec->fetch_assoc()): ?>
                  <tr>
                    <td><?= date('d/m/Y H:i', strtotime($a['fecha'])) ?></td>
                    <td><?= htmlspecialchars($a['usuario']) ?></td>
                    <td><?= htmlspecialchars($a['mascota']) ?></td>
                  </tr>
                <?php endwhile; else: ?>
                  <tr><td colspan="3" class="text-center text-muted">Sin registros aún</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<?php include __DIR__ . '/app/views/partials/footer.php'; ?>
