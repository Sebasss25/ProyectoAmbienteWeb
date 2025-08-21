<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../models/Reporte.php';

class ReporteController
{
    public function index()
    {
        require_login();
        $rep = new Reporte();
        $reportes = $rep->all();
        require 'app/views/Reportes/index.php';
    }

    public function create()
    {
        require_login();
        $rep = new Reporte();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'fecha'     => $_POST['fecha'],
                'usuario'   => (int) $_POST['usuario'],
                'mascota'   => $_POST['mascota'] ? (int) $_POST['mascota'] : null,
                'provincia' => $_POST['provincia'],
                'canton'    => $_POST['canton'],
                'distrito'  => $_POST['distrito'],
                'detalles'  => $_POST['detalles'],
            ];

            $rep->create($data);
            header("Location: Reportes.php");
            exit();
        }

        require 'app/views/Reportes/create.php';
    }

    public function delete($id)
    {
        require_login();
        $rep = new Reporte();
        $rep->delete($id);
        header("Location: Reportes.php");
        exit();
    }
}
