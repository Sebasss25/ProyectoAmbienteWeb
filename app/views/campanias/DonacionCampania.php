<?php
session_start();
include __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../../models/CampaniaDonacion.php';


$donacionModel = new CampaniaDonacion();
$donaciones = $donacionModel->obtenerTodasLasDonaciones();
$totalRecaudadoGeneral = $donacionModel->obtenerTotalDonadoGeneral();

$campaignIdFilter = $_GET['campaignId'] ?? 'Sin Filtro';
if ($campaignIdFilter !== 'Sin Filtro' && is_numeric($campaignIdFilter)) {

}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Donaciones a Campañas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="css/estilos.css" />
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-4">Lista de Donaciones</h1>

            <form class="d-flex" role="search" method="GET">
                <select class="form-select me-2" name="campaignId" id="floatingSelect"
                    aria-label="Floating label select example">
                    <option value="Sin Filtro" <?= $campaignIdFilter === 'Sin Filtro' ? 'selected' : '' ?>>Sin Filtro</option>
                    <option value="1" <?= $campaignIdFilter === '1' ? 'selected' : '' ?>>Campaña Veterinaria</option>
                    <option value="2" <?= $campaignIdFilter === '2' ? 'selected' : '' ?>>Campaña 2</option>
                    <option value="3" <?= $campaignIdFilter === '3' ? 'selected' : '' ?>>Campaña 3</option>
                </select>

                <button class="btn btn-secondary ml-2" type="submit">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>

            <a href="#" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva Donación
            </a>
        </div>
        
        <?php if (!empty($_SESSION['donacion_success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['donacion_success']; unset($_SESSION['donacion_success']); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                    onclick="this.parentElement.style.display='none';">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['donacion_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['donacion_error']; unset($_SESSION['donacion_error']); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                    onclick="this.parentElement.style.display='none';">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Cantidad</th>
                        <th>Usuario</th>
                        <th>Campaña</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($donaciones)): ?>
                        <?php foreach ($donaciones as $donacion): ?>
                            <tr>
                                <td><?= htmlspecialchars($donacion['id']) ?></td>
                                <td><?= htmlspecialchars(date('d/m/Y', strtotime($donacion['fecha']))) ?></td>
                                <td>$<?= htmlspecialchars(number_format($donacion['cantidad'], 2)) ?></td>
                                <td><?= htmlspecialchars($donacion['usuario_email']) ?></td>
                                <td><?= htmlspecialchars($donacion['campania_nombre']) ?></td>
                                <td>
                                    <a href="campanias.php" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Volver</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No hay donaciones registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <hr />

    <div class="container mt-4">
        <div class="d-flex justify-content-end align-items-center mb-4">
            <h6 class="display-2 text-dark me-4">Total Recaudado:</h6>
            <h6 class="display-2 text-success">$<?= htmlspecialchars(number_format($totalRecaudadoGeneral, 2)) ?></h6>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
include __DIR__ . '/../partials/footer.php';
?>
    