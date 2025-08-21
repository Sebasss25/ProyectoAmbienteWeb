<?php
require_once __DIR__ . '/app/controllers/HistorialMedicoController.php';

$controller = new HistorialMedicoController();

$action     = $_GET['action'] ?? 'index';
$mascotaId  = isset($_GET['mascota_id']) ? (int)$_GET['mascota_id'] : 0;
$id         = isset($_GET['id']) ? (int)$_GET['id'] : 0;

switch ($action) {
  case 'create': $controller->create($mascotaId); break;
  case 'edit':   $controller->edit($id, $mascotaId); break;
  case 'delete': $controller->delete($id, $mascotaId); break;
  default:       $controller->index($mascotaId); 
}
