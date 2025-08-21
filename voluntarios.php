<?php
require_once __DIR__ . '/app/controllers/VoluntariosController.php';
$controller = new VoluntariosController();

$action  = $_GET['action'] ?? 'index';
$id      = isset($_GET['id']) ? (int) $_GET['id'] : 0;          
$tareaId = isset($_GET['tarea_id']) ? (int) $_GET['tarea_id'] : 0;
$estado  = isset($_GET['estado']) ? (string) $_GET['estado'] : '';

switch ($action) {
  case 'delete':        $controller->delete($id); break;
  case 'search':        $controller->search($estado); break;

  case 'activar_select':$controller->activar_select(); break;      
  case 'activar':       $controller->activar($id); break;         
  case 'inactivar':     $controller->inactivar($id); break;      

  case 'tareas':        $controller->tareas($id); break;          
  case 'tarea_create':  $controller->tarea_create($id); break;
  case 'tarea_edit':    $controller->tarea_edit($tareaId, $id); break;
  case 'tarea_delete':  $controller->tarea_delete($tareaId, $id); break;

  case 'mis_tareas':    $controller->mis_tareas(); break;

  default:              $controller->index();
}
