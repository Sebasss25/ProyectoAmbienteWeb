<?php
require_once __DIR__ . '/../../config/auth.php';
start_session_safe();

if (!defined('BASE_URL')) {
  $dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
  define('BASE_URL', $dir === '/' ? '' : $dir);
}

$homeUrl = home_url_by_role();
$rol = $_SESSION['rol'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Patitas Conectadas</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <link rel="stylesheet" href="/ProyectoAmbienteWeb/css/estilos.css?v=2">
</head>
<body>
<header class="header sticky-top bg-light py-2">
  <div class="container-fluid d-flex justify-content-center align-items-center">
    <nav id="navmenu" class="navmenu">
      <ul class="list-inline m-0 d-flex align-items-center">
        <li class="list-inline-item font-weight-bold h5 mb-0">
          <a href="<?= htmlspecialchars($homeUrl) ?>" class="text-dark text-decoration-none">
            Patitas Conectadas
          </a>
        </li>

        <li class="list-inline-item"><a href="<?= htmlspecialchars($homeUrl) ?>">Inicio</a></li>

        <?php if ($rol === 'admin' || $rol === 'voluntario'): ?>
          <li class="list-inline-item"><a href="<?= htmlspecialchars(BASE_URL) ?>/mascotas.php">Mascotas</a></li>
          <li class="list-inline-item"><a href="<?= htmlspecialchars(BASE_URL) ?>/eventos.php">Eventos</a></li>
          <li class="list-inline-item"><a href="<?= htmlspecialchars(BASE_URL) ?>/campanias.php">Campañas</a></li>
          <li class="list-inline-item"><a href="<?= htmlspecialchars(BASE_URL) ?>/usuarios.php">Usuarios</a></li>
          <li class="list-inline-item"><a href="<?= htmlspecialchars(BASE_URL) ?>/voluntarios.php">Voluntarios</a></li>
          <li class="list-inline-item"><a href="<?= htmlspecialchars(BASE_URL) ?>/inventario.php">Inventario</a></li>

          <?php if ($rol === 'admin'): ?>
            <li class="list-inline-item"><a href="<?= htmlspecialchars(BASE_URL) ?>/Reportes.php">Reportes</a></li>
          <?php else: ?>
            <li class="list-inline-item"><a href="<?= htmlspecialchars(BASE_URL) ?>/Reportes.php?action=create">Reportes</a></li>
          <?php endif; ?>

        <?php else: ?>
          <li class="list-inline-item"><a href="<?= htmlspecialchars(BASE_URL) ?>/mascotas_public.php">Mascotas</a></li>
          <li class="list-inline-item"><a href="<?= htmlspecialchars(BASE_URL) ?>/eventos_public.php">Eventos</a></li>
          <li class="list-inline-item"><a href="<?= htmlspecialchars(BASE_URL) ?>/campanias_public.php">Campañas</a></li>
          <li class="list-inline-item"><a href="<?= htmlspecialchars(BASE_URL) ?>/Reportes.php?action=create">Reportes</a></li>
        <?php endif; ?>

        <?php if(isset($_SESSION['user_id'])): ?>
          <li class="list-inline-item font-weight-bold text-dark">
            <?= htmlspecialchars($_SESSION['nombre']) ?>
          </li>
          <li class="list-inline-item">
            <a class="btn btn-danger btn-sm text-white" href="<?= htmlspecialchars(BASE_URL) ?>/logout.php">Cerrar Sesión</a>
          </li>
        <?php else: ?>
          <li class="list-inline-item">
            <a class="btn btn-primary btn-sm text-white" href="<?= htmlspecialchars(BASE_URL) ?>/register.php">Registro</a>
          </li>
          <li class="list-inline-item">
            <a class="btn btn-success btn-sm text-white" href="<?= htmlspecialchars(BASE_URL) ?>/login.php">Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</header>
