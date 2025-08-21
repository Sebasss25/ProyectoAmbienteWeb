<?php require 'app/views/partials/header.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
        <h3>Lista de Reportes</h3>
        <a href="Reportes.php?action=create" class="btn btn-primary">Agregar Reporte</a>
    </div>

    <div class="card shadow-lg">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Mascota</th>
                        <th>Provincia</th>
                        <th>Cantón</th>
                        <th>Distrito</th>
                        <th>Detalles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($reportes as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['fecha']) ?></td>
                        <td><?= htmlspecialchars($r['usuario']) ?></td>
                        <td><?= htmlspecialchars($r['mascota']) ?></td>
                        <td><?= htmlspecialchars($r['provincia']) ?></td>
                        <td><?= htmlspecialchars($r['canton']) ?></td>
                        <td><?= htmlspecialchars($r['distrito']) ?></td>
                        <td><?= htmlspecialchars($r['detalles']) ?></td>
                        <td>
                            <a href="Reportes.php?action=delete&id=<?= $r['id'] ?>" 
                               onclick="return confirm('¿Seguro que desea eliminar este reporte?')" 
                               class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'app/views/partials/footer.php'; ?>
