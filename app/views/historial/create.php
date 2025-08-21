<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
  <div class="hist-container">
    <div class="hist-card">
      <div class="hist-card-header">
        <i class="fas fa-plus-circle"></i>
        Nuevo registro médico - <?= htmlspecialchars($mascota['nombre'] ?? 'Mascota') ?>
      </div>

      <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger mb-0"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
      <?php endif; ?>

      <div class="p-3">
        <form method="POST" action="" class="hist-form">
          <input type="hidden" name="mascota_id" value="<?= (int)($mascota['id'] ?? 0) ?>">

          <div class="form-row">
            <div class="form-group col-md-3">
              <label>Fecha de consulta</label>
              <input type="date" name="fecha_consulta" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="form-group col-md-5">
              <label>Motivo</label>
              <input type="text" name="motivo" class="form-control" maxlength="200" required>
            </div>
            <div class="form-group col-md-4">
              <label>Próximo control</label>
              <input type="date" name="proximo_control" class="form-control">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label>Veterinario</label>
              <input type="text" name="veterinario" class="form-control" maxlength="120">
            </div>
            <div class="form-group col-md-2">
              <label>Peso (kg)</label>
              <input type="number" step="0.01" min="0" name="peso_kg" class="form-control">
            </div>
            <div class="form-group col-md-2">
              <label>Temp (°C)</label>
              <input type="number" step="0.1" name="temperatura_c" class="form-control">
            </div>
            <div class="form-group col-md-4">
              <label>Estado del tratamiento</label>
              <select name="activo" class="form-control" required>
                <option value="1" selected>Activo (En tratamiento)</option>
                <option value="0">Inactivo (Disponible)</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label>Diagnóstico</label>
            <textarea name="diagnostico" class="form-control" rows="3"></textarea>
          </div>

          <div class="form-group">
            <label>Tratamiento</label>
            <textarea name="tratamiento" class="form-control" rows="3"></textarea>
          </div>

          <div class="form-group">
            <label>Observaciones</label>
            <textarea name="observaciones" class="form-control" rows="3"></textarea>
          </div>

          <div class="form-group">
            <label>URL de adjunto (opcional)</label>
            <input type="url" name="adjunto_url" class="form-control" placeholder="https://...">
          </div>

          <div class="d-flex justify-content-between">
            <a href="historial.php?mascota_id=<?= (int)($mascota['id'] ?? 0) ?>" class="hist-btn">Volver</a>
            <button type="submit" class="hist-btn hist-btn--primary">
              <i class="fas fa-save"></i> Guardar
            </button>
          </div>
        </form>
      </div>

      <div class="hist-card-footer d-flex justify-content-end">
        <div class="hist-pill">
          <i class="far fa-calendar"></i> Nuevo: <?= date('Y-m-d') ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
