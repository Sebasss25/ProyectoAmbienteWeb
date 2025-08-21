<?php
require_once __DIR__ . '/app/controllers/ReporteController.php';

$controller = new ReporteController();
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'delete':
        if ($id) $controller->delete($id);
        break;
    default:
        $controller->index();
}
