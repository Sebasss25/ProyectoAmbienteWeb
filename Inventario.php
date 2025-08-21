<?php
require_once __DIR__ . '/app/controllers/InventarioController.php';
$controller = new InventarioController();

$action = $_GET['action'] ?? 'index';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$nombre = isset($_GET['nombre']) ? (string) $_GET['nombre'] : '';

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'delete':
        $controller->delete($id);
        break;
    case 'search':
        $controller->search($nombre);
        break;
    default:
        $controller->index();
}
