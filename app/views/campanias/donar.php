<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h3>Donar a la campaña: <?= htmlspecialchars($campania['nombre']) ?></h3>
    </div>
    <div class="card-body">
      <?php if (!empty($_SESSION['campanias_error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['campanias_error']; unset($_SESSION['campanias_error']); ?></div>
      <?php endif; ?>
      
      <form method="POST" action="campanias.php?action=donar&id=<?= $campania['id'] ?>">
        <div class="form-group mb-3">
          <label for="cantidad" class="form-label">Monto a donar ($)</label>
          <div class="input-group">
            <span class="input-group-text">$</span>
            <input type="number" class="form-control" id="cantidad" name="cantidad" 
                   min="0.01" step="0.01" required>
          </div>
          <small class="text-muted">Monto mínimo: $0.01</small>
        </div>
        
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-success btn-lg">
            <i class="fas fa-hand-holding-heart"></i> Confirmar Donación
          </button>
          <a href="campanias.php?action=detalles&id=<?= $campania['id'] ?>" class="btn btn-secondary">
            Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>