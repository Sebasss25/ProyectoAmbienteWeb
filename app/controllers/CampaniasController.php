<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../models/Campania.php';
require_once __DIR__ . '/../models/CampaniaDonacion.php';

class CampaniasController
{
  public function index()
  {
    require_login();
    $c = new Campania();
    $campanias = $c->all();
    require 'app/views/campanias/index.php';
  }

  public function create()
  {
    require_role(['admin']);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Validar sesión primero
      if (!isset($_SESSION['user_id'])) {
        $_SESSION['campanias_error'] = 'No se pudo identificar al usuario responsable';
        header('Location: campanias.php?action=create');
        exit();
      }

      $data = [
        'nombre' => trim($_POST['nombre']),
        'descripcion' => trim($_POST['descripcion']),
        'fechaInicio' => $_POST['fechaInicio'],
        'fechaFin' => $_POST['fechaFin'],
        'objetivo' => (float) $_POST['objetivo'],
        'estado' => $_POST['estado'],
        'usuario' => (int) $_SESSION['user_id']
      ];

      $c = new Campania();
      if ($c->create($data)) {
        $_SESSION['campanias_success'] = 'Campaña creada correctamente';
        header('Location: campanias.php');
      } else {
        $_SESSION['campanias_error'] = 'Error al crear campaña: ' . $c->getError();
        header('Location: campanias.php?action=create');
      }
      exit();
    }
    require 'app/views/campanias/create.php';
  }

  public function edit(int $id)
  {
    require_role(['admin']);
    $c = new Campania();
    $campania = $c->find($id);

    if (!$campania) {
      header('Location: campanias.php');
      exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = [
        'nombre' => trim($_POST['nombre']),
        'descripcion' => trim($_POST['descripcion']),
        'fechaInicio' => $_POST['fechaInicio'],
        'fechaFin' => $_POST['fechaFin'],
        'objetivo' => (float) $_POST['objetivo'],
        'estado' => $_POST['estado']
      ];

      if ($c->update($id, $data)) {
        $_SESSION['campanias_success'] = 'Campaña actualizada correctamente';
      } else {
        $_SESSION['campanias_error'] = 'Error al actualizar: ' . $c->getError();
      }
      header('Location: campanias.php');
      exit();
    }

    require 'app/views/campanias/edit.php';
  }

  public function delete(int $id)
  {
    require_role(['admin']);
    $c = new Campania();
    if ($c->delete($id)) {
      $_SESSION['campanias_success'] = 'Campaña eliminada correctamente';
    } else {
      $_SESSION['campanias_error'] = 'Error al eliminar: ' . $c->getError();
    }
    header('Location: campanias.php');
    exit();
  }

  public function detalles(int $id)
  {
    $model = new Campania();
    $campania = $model->find($id);

    if (!$campania) {
      $_SESSION['campanias_error'] = 'Campaña no encontrada';
      header('Location: campanias.php');
      exit();
    }
    require 'app/views/campanias/detalles.php';
  }

  public function donar(int $campania_id)
  {
    require_login();

    if (($_SESSION['rol'] ?? '') !== 'usuario') {
      $_SESSION['campanias_error'] = 'Solo los usuarios pueden realizar donaciones';
      header('Location: campanias.php?action=detalles&id=' . $campania_id);
      exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $cantidad = (float) $_POST['cantidad'];
      $campaniaModel = new Campania();
      $donacionModel = new CampaniaDonacion();

      // Verificar que la campaña existe y está activa
      $campania = $campaniaModel->find($campania_id);
      if (!$campania || $campania['estado'] !== 'Activa') {
        $_SESSION['campanias_error'] = 'No se puede donar a esta campaña';
        header('Location: campanias.php');
        exit();
      }


      if ($cantidad <= 0) {
        $_SESSION['campanias_error'] = 'El monto debe ser mayor a cero';
        header('Location: campanias.php?action=detalles&id=' . $campania_id);
        exit();
      }

      if ($donacionModel->registrarDonacion($campania_id, (int) $_SESSION['user_id'], $cantidad)) {
        $_SESSION['campanias_success'] = '¡Donación registrada exitosamente! Gracias por tu apoyo.';


        $totalDonado = $donacionModel->totalDonado($campania_id);
        if ($totalDonado >= $campania['objetivo']) {
          $campaniaModel->update($campania_id, ['estado' => 'Completada']);
        }
      } else {
        $_SESSION['campanias_error'] = $donacionModel->getError() ?? 'Error al registrar la donación';
      }

      header('Location: campanias.php?action=detalles&id=' . $campania_id);
      exit();
    }

    $campania = (new Campania())->find($campania_id);
    if (!$campania || $campania['estado'] !== 'Activa') {
      $_SESSION['campanias_error'] = 'No se puede donar a esta campaña';
      header('Location: campanias.php');
      exit();
    }

    require 'app/views/campanias/donar.php';
  }

}