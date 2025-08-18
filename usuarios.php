<?php
require_once __DIR__ . '/app/controllers/UsuariosController.php';
$controller = new UsuariosController();

$action = $_GET['action'] ?? 'index';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

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
    default:
        $controller->index();
}
