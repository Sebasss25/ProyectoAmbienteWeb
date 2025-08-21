<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4" style="max-width: 960px;">

  <div class="card shadow-sm">
    <div class="card-header text-white" style="background:#14b8d4;">
      <strong>Detalles de Mascota</strong>
    </div>

    <div class="card-body p-0">
      <table class="table mb-0">
        <tbody>
          <tr>
            <th class="w-25 text-muted">Nombre:</th>
            <td><?= htmlspecialchars($m['nombre']) ?></td>
          </tr>
          <tr>
            <th class="text-muted">Raza:</th>
            <td><?= htmlspecialchars($m['raza']) ?></td>
          </tr>
          <tr>
            <th class="text-muted">Edad:</th>
            <td><?= (int)$m['edad'] ?></td>
          </tr>
          <tr>
            <th class="text-muted">Estado:</th>
            <td>
              <?php
                $badge = 'badge-secondary';
                if ($m['estado'] === 'Disponible') {
                  $badge = 'badge-success';
                } elseif ($m['estado'] === 'En comunicación') {
                  $badge = 'badge-info';
                } elseif ($m['estado'] === 'En tratamiento') {
                  $badge = 'badge-warning';
                } elseif ($m['estado'] === 'Adoptado') {
                  $badge = 'badge-dark';
                }
              ?>
              <span class="badge <?= $badge ?>"><?= htmlspecialchars($m['estado']) ?></span>
            </td>
          </tr>
          <tr>
            <th class="align-top text-muted">Descripción:</th>
            <td><?= nl2br(htmlspecialchars($m['descripcion'])) ?></td>
          </tr>
          <tr>
            <th class="text-muted align-top">Foto:</th>
            <td>
              <img
                src="<?= htmlspecialchars($m['foto'] ?: 'img/placeholder.jpg') ?>"
                alt="Foto de <?= htmlspecialchars($m['nombre']) ?>"
                class="img-fluid rounded border"
                style="max-width: 320px;"
                onerror="this.onerror=null;this.src='img/placeholder.jpg';">
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="card-footer bg-white d-flex flex-wrap gap-2">
      <?php
        $rol = $_SESSION['rol'] ?? 'usuario';
        $esAdminOVol = ($rol === 'admin' || $rol === 'voluntario');
      ?>

      <?php if ($esAdminOVol): ?>
        <a href="mascotas.php?action=edit&id=<?= (int)$m['id'] ?>" class="btn btn-warning mb-2 mr-2">
          <i class="fas fa-edit"></i> Editar
        </a>
      <?php endif; ?>

      <a href="historial.php?mascota_id=<?= (int)$m['id'] ?>" class="btn btn-info mb-2 mr-2">
        <i class="fas fa-notes-medical"></i> Historial médico
      </a>

      <?php if (!$esAdminOVol): ?>
        <?php if ($m['estado'] === 'Disponible'): ?>
          <a href="adopciones.php?action=create&mascota_id=<?= (int)$m['id'] ?>" class="btn btn-success mb-2 mr-2">
            <i class="fas fa-heart"></i> Adoptar
          </a>
        <?php endif; ?>
      <?php endif; ?>

      <a href="<?= $esAdminOVol ? 'mascotas.php' : 'mascotas_public.php' ?>" class="btn btn-secondary mb-2">
        Volver
      </a>
    </div>
  </div>

</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
