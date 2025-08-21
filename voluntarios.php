<?php
require_once __DIR__ . '/app/controllers/VoluntariosController.php';
$controller = new VoluntariosController();

$action = $_GET['action'] ?? 'index';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$estado = isset($_GET['estado']) ? (string) $_GET['estado'] : '';

switch ($action) {
    case 'create':
        $controller->create();
        break;
    // case 'edit':
    //     $controller->edit($id);
    //     break;
    case 'delete':
        $controller->delete($id);
        break;
    case 'search':
        $controller->search($estado);
        break;
    default:
        $controller->index();
}
