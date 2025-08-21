<?php require 'app/views/partials/header.php'; ?>

<div class="container mt-5">
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Nuevo Reporte</h4>
        </div>
        <div class="card-body">
            <form method="post" action="Reportes.php?action=create">

                <div class="mb-3">
                    <label class="form-label">Fecha</label>
                    <input type="datetime-local" name="fecha" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Usuario (ID)</label>
                    <input type="number" name="usuario" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mascota (ID)</label>
                    <input type="number" name="mascota" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Provincia</label>
                    <input type="text" name="provincia" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cantón</label>
                    <input type="text" name="canton" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Distrito</label>
                    <input type="text" name="distrito" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Detalles</label>
                    <textarea name="detalles" class="form-control" rows="4" required></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="Reportes.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require 'app/views/partials/footer.php'; ?>
