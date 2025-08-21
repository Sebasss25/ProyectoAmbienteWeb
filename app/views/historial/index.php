<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
  <div class="hist-container">
    <div class="hist-card">
      <div class="hist-card-header">
        <i class="fas fa-notes-medical"></i>
        Historial médico de <?= htmlspecialchars($mascota['nombre'] ?? 'Mascota') ?>
      </div>

      <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success mb-0"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
      <?php endif; ?>
      <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger mb-0"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
      <?php endif; ?>

      <div class="hist-table-wrap">
        <?php if (empty($items)): ?>
          <div class="p-3">
            <div class="hist-empty">
              <h5>Sin registros</h5>
              <p>Esta mascota aún no tiene historial médico registrado.</p>
            </div>
          </div>
        <?php else: ?>
          <table class="hist-table">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Motivo</th>
                <th>Diagnóstico</th>
                <th>Tratamiento</th>
                <th>Veterinario</th>
                <th>Peso (kg)</th>
                <th>Temp (°C)</th>
                <th>Próximo control</th>
                <th>Estado</th> <!-- NUEVO -->
                <th>Adjunto</th>
                <?php if (!empty($puedeEditar)): ?><th>Acciones</th><?php endif; ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($items as $h): ?>
                <tr>
                  <td><?= htmlspecialchars($h['fecha_consulta']) ?></td>
                  <td class="hist-cell--wrap"><?= htmlspecialchars($h['motivo']) ?></td>
                  <td class="hist-cell--wrap"><?= nl2br(htmlspecialchars($h['diagnostico'])) ?></td>
                  <td class="hist-cell--wrap"><?= nl2br(htmlspecialchars($h['tratamiento'])) ?></td>
                  <td><?= htmlspecialchars($h['veterinario']) ?></td>
                  <td><?= $h['peso_kg'] !== null ? (float)$h['peso_kg'] : '-' ?></td>
                  <td><?= $h['temperatura_c'] !== null ? (float)$h['temperatura_c'] : '-' ?></td>
                  <td><?= htmlspecialchars($h['proximo_control'] ?? '-') ?></td>
                  <td>
                    <?php if (!empty($h['activo'])): ?>
                      <span class="badge badge-warning">Activo</span>
                    <?php else: ?>
                      <span class="badge badge-secondary">Inactivo</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if (!empty($h['adjunto_url'])): ?>
                      <a href="<?= htmlspecialchars($h['adjunto_url']) ?>" target="_blank" rel="noopener">Ver</a>
                    <?php else: ?>-<?php endif; ?>
                  </td>
                  <?php if (!empty($puedeEditar)): ?>
                    <td>
                      <div class="hist-row-actions">
                        <a class="btn btn-sm btn-warning" href="historial.php?action=edit&id=<?= (int)$h['id'] ?>&mascota_id=<?= (int)$mascota['id'] ?>">
                          <i class="fas fa-edit"></i>
                        </a>
                        <a class="btn btn-sm btn-danger" href="historial.php?action=delete&id=<?= (int)$h['id'] ?>&mascota_id=<?= (int)$mascota['id'] ?>" onclick="return confirm('¿Eliminar registro?')">
                          <i class="fas fa-trash"></i>
                        </a>
                      </div>
                    </td>
                  <?php endif; ?>
                </tr>
                <?php if (!empty($h['observaciones'])): ?>
                  <tr class="is-subrow">
                    <td colspan="<?= !empty($puedeEditar) ? 11 : 10 ?>">
                      <strong>Observaciones:</strong><br>
                      <?= nl2br(htmlspecialchars($h['observaciones'])) ?>
                    </td>
                  </tr>
                <?php endif; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>

      <div class="hist-card-footer d-flex justify-content-between align-items-center">
        <div class="hist-pill">
          <i class="far fa-calendar"></i>
          Última actualización: <?= date('Y-m-d') ?>
        </div>
        <div class="hist-row-actions">
          <?php if (!empty($puedeEditar)): ?>
            <a class="hist-btn hist-btn--primary" href="historial.php?action=create&mascota_id=<?= (int)($mascota['id'] ?? 0) ?>">
              <i class="fas fa-plus"></i> Nuevo registro
            </a>
          <?php endif; ?>
          <a class="hist-btn" href="mascotas.php?action=detalles&id=<?= (int)($mascota['id'] ?? 0) ?>">Volver</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
