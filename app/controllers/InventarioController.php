<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../models/Inventario.php';

class InventarioController
{
    public function index()
    {
        require_login();
        $inv = new Inventario();
        $items = $inv->all();
        require 'app/views/Inventario/index.php';
    }

    public function create()
    {
        require_login();
        $inv = new Inventario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => $_POST['nombre'],
                'tipo' => $_POST['tipo'],
                'cantidad' => (int) $_POST['cantidad'],
                'fechaIngreso' => $_POST['fechaIngreso'],
                'fechaCaducidad' => $_POST['fechaCaducidad'] ?: null,
                'proveedor' => $_POST['proveedor'],
                'fuente' => $_POST['fuente'],
            ];

            $inv->create($data);
            header("Location: Inventario.php");
            exit();
        }

        require 'app/views/Inventario/create.php';
    }



    public function search(string $nombre)
    {
        require_login();
        $inv = new Inventario();
        $items = $inv->search($nombre);

        if ($items && count($items) > 0) {
            $_SESSION['inventario_success'] = 'Ítems encontrados';
        } else {
            $items = [];
            $_SESSION['error'] = 'No se encontraron ítems con ese nombre';
        }

        require 'app/views/Inventario/index.php';
    }

    public function delete(int $id)
    {
        require_role(['admin']);
        $inv = new Inventario();
        if ($inv->delete($id)) {
            $_SESSION['success'] = 'Ítem eliminado';
        } else {
            $_SESSION['error'] = 'Error: ' . $inv->getError();
        }
        header('Location: inventario.php');
        exit();
    }
}
