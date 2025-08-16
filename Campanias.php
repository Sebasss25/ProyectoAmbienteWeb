<?php
require_once __DIR__ . '/app/controllers/CampaniasController.php';
$controller = new CampaniasController();

$action = $_GET['action'] ?? 'index';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->edit($id);
        break;
    case 'delete':
        $controller->delete($id);
        break;
    case 'detalles':
        $controller->detalles($id);
        break;
    case 'donar':
        $controller->donar($id);
        break;
    case 'verDonaciones':
        $controller->verDonaciones();
        break;
    default:
        $controller->index();
}
