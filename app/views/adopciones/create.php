<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4" style="max-width:760px;">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Iniciar proceso de adopción</h1>
    <a href="mascotas_public.php" class="btn btn-secondary">Volver</a>
  </div>

  <div class="card shadow">
    <div class="card-body">
      <p class="mb-3">Estás solicitando adoptar a <strong><?= htmlspecialchars($mascota_nombre) ?></strong>. Completa el formulario y <strong>te enviaremos los detalles por correo</strong> para continuar.</p>
      <?php if (!empty($_SESSION['adopciones_error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['adopciones_error']); unset($_SESSION['adopciones_error']); ?></div>
      <?php endif; ?>
      <form method="POST">
        <div class="form-group">
          <label>¿Por qué deseas adoptar?</label>
          <textarea name="motivo" class="form-control" rows="3" required></textarea>
        </div>
        <div class="form-group">
          <label>Experiencia previa con mascotas (opcional)</label>
          <textarea name="experiencia" class="form-control" rows="3"></textarea>
        </div>
        <div class="form-group">
          <label>Correo o teléfono de contacto</label>
          <input type="text" name="contacto" class="form-control" value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>" required>
        </div>
        <button class="btn btn-success"><i class="fas fa-paper-plane"></i> Enviar solicitud</button>
      </form>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
