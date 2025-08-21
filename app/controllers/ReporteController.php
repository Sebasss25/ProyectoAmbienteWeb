<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../models/Reporte.php';

class ReporteController
{
    public function index()
    {
        require_role(['admin']);
        $rep = new Reporte();
        $reportes = $rep->all();
        require 'app/views/Reportes/index.php';
    }

    public function create()
    {

        $rep = new Reporte();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;

            $data = [
                'fecha'     => !empty($_POST['fecha']) ? $_POST['fecha'] : date('Y-m-d H:i:s'),
                'usuario'   => $usuarioId,   
                'mascota'   => null,        
                'provincia' => trim($_POST['provincia'] ?? ''),
                'canton'    => trim($_POST['canton'] ?? ''),
                'distrito'  => trim($_POST['distrito'] ?? ''),
                'detalles'  => trim($_POST['detalles'] ?? ''),
            ];

            if ($rep->create($data)) {
                $_SESSION['success'] = '¡Reporte enviado correctamente!';
                if (($_SESSION['rol'] ?? '') === 'admin') {
                    header('Location: Reportes.php');
                } else {
                    header('Location: Reportes.php?action=create');
                }
            } else {
                $_SESSION['error'] = 'Error al guardar el reporte: ' . $rep->getError();
                header('Location: Reportes.php?action=create');
            }
            exit();
        }

        require 'app/views/Reportes/create.php';
    }

    public function delete($id)
    {
        require_role(['admin']);
        $rep = new Reporte();
        if ($rep->delete((int)$id)) {
            $_SESSION['success'] = 'Reporte eliminado';
        } else {
            $_SESSION['error'] = 'Error al eliminar: ' . $rep->getError();
        }
        header("Location: Reportes.php");
        exit();
    }
}
