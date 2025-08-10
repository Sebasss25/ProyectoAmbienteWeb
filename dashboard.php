<?php
require_once __DIR__ . '/app/config/auth.php';
require_once __DIR__ . '/app/config/db.php';
require_once __DIR__ . '/app/models/Mascota.php';
start_session_safe();

$db = Database::connect();

$totMascotas    = (int)$db->query("SELECT COUNT(*) c FROM Mascotas")->fetch_assoc()['c'];
$totAdopciones  = (int)$db->query("SELECT COUNT(*) c FROM Adopciones")->fetch_assoc()['c'];
$totCampanias   = (int)$db->query("SELECT COUNT(*) c FROM Campanias WHERE estado='Activa'")->fetch_assoc()['c'];
$totVoluntarios = (int)$db->query("SELECT COUNT(*) c FROM Voluntarios WHERE estado='Activo'")->fetch_assoc()['c'];

$mModel   = new Mascota();
$disponibles = $mModel->disponibles(9); 

include 'app/views/partials/header.php';
?>

<div class="home-container">

  <div class="jumbotron-fluid text-center text-white py-5 mb-0" style="background-color:#10bc69 !important;">
    <div class="container">
      <h1 class="display-4 text-white">Bienvenido a Patitas Conectadas</h1>
      <p class="lead text-white">Sistema integral de gestión para protectora de animales</p>
      <hr class="my-4 bg-light">
      <p>Plataforma unificada para el manejo de todos los procesos de la organización</p>
    </div>
  </div>

  <div class="bg-light py-4">
    <div class="container">
      <div class="row text-center">
        <div class="col-md-3"><h3 class="text-success"><?= $totMascotas ?></h3><p class="mb-0">Mascotas rescatadas</p></div>
        <div class="col-md-3"><h3 class="text-success"><?= $totAdopciones ?></h3><p class="mb-0">Adopciones exitosas</p></div>
        <div class="col-md-3"><h3 class="text-success"><?= $totCampanias ?></h3><p class="mb-0">Campañas activas</p></div>
        <div class="col-md-3"><h3 class="text-success"><?= $totVoluntarios ?></h3><p class="mb-0">Voluntarios activos</p></div>
      </div>
    </div>
  </div>

  <div class="container py-5">
    <h2 class="text-center mb-4">Módulos Principales</h2>
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <div class="card-icon bg-info text-white text-center py-3"><i class="fas fa-paw fa-3x"></i></div>
          <div class="card-body text-center">
            <h5 class="card-title">Mascotas</h5>
            <p class="card-text">Echa un vistazo a las mascotas disponibles.</p>
            <a href="mascotas_public.php" class="btn btn-success"><i class="fas fa-list"></i> Ver</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <div class="card-icon bg-success text-white text-center py-3"><i class="fas fa-calendar-alt fa-3x"></i></div>
          <div class="card-body text-center">
            <h5 class="card-title">Eventos</h5>
            <p class="card-text">¡Echa un vistazo a los eventos disponibles!</p>
            <a href="#" class="btn btn-success" disabled><i class="fas fa-list"></i> Listado</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <div class="card-icon bg-warning text-white text-center py-3"><i class="fas fa-hand-holding-heart fa-3x"></i></div>
          <div class="card-body text-center">
            <h5 class="card-title">Campañas</h5>
            <p class="card-text">¡Echa un vistazo a las campañas activas!</p>
            <a href="#" class="btn btn-success" disabled><i class="fas fa-list"></i> Listado</a>
          </div>
        </div>
      </div>
    </div>
<?php include 'app/views/partials/footer.php'; ?>
