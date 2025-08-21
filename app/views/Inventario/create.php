<?php require 'app/views/partials/header.php'; ?>

<div class="container mt-5">
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Agregar Nuevo Inventario</h4>
        </div>
        <div class="card-body">
            <form method="post" action="Inventario.php?action=create">
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo</label>
                    <input type="text" name="tipo" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha de Ingreso</label>
                    <input type="datetime-local" name="fechaIngreso" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha de Caducidad</label>
                    <input type="datetime-local" name="fechaCaducidad" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Proveedor</label>
                    <input type="text" name="proveedor" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Fuente</label>
                    <select name="fuente" class="form-select">
                        <option value="Compra">Compra</option>
                        <option value="Donación">Donación</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="Inventario.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require 'app/views/partials/footer.php'; ?>
