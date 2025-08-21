<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../models/Eventos.php';
require_once __DIR__ . '/../models/EventoAsistencia.php';

class EventosController
{
  public function index()
  {
    require_login();
    $e = new Evento();
    $eventos = $e->all();
    require 'app/views/Eventos/index.php';
  }

  public function create()
  {
    require_login();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = [
        'nombre' => $_POST['nombre'] ?? '',
        'descripcion' => $_POST['descripcion'] ?? '',
        'fecha' => $_POST['fecha'] ?? '',
        'ubicacion' => $_POST['ubicacion'] ?? '',
        'responsable' => (int) ($_SESSION['user_id']),
        'tipo' => $_POST['tipo'] ?? 'Presencial',
        'estado' => $_POST['estado'] ?? 'Planificado'
      ];
      $e = new Evento();
      if ($e->create($data)) {
        $_SESSION['success'] = 'Evento creado correctamente';
        header('Location: eventos.php');
      } else {
        $_SESSION['error'] = 'Error: ' . $e->getError();
        header('Location: eventos.php?action=create');
      }
      exit();
    }
    require 'app/views/Eventos/create.php';
  }

  public function edit(int $id)
  {
    require_role(['admin', 'voluntario']); 
    $e = new Evento();
    $evento = $e->find($id);
    if (!$evento) {
      header('Location: eventos.php');
      exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = [
        'nombre' => $_POST['nombre'] ?? '',
        'descripcion' => $_POST['descripcion'] ?? '',
        'fecha' => $_POST['fecha'] ?? '',
        'ubicacion' => $_POST['ubicacion'] ?? '',
        'responsable' => (int) ($evento['responsable']),
        'tipo' => $_POST['tipo'] ?? 'Presencial',
        'estado' => $_POST['estado'] ?? 'Planificado'
      ];
      if ($e->update($id, $data)) {
        $_SESSION['success'] = 'Evento actualizado';
      } else {
        $_SESSION['error'] = 'Error: ' . $e->getError();
      }
      header('Location: eventos.php');
      exit();
    }
    require 'app/views/Eventos/edit.php';
  }

  public function delete(int $id)
  {
    require_role(['admin']);
    $e = new Evento();
    if ($e->delete($id)) {
      $_SESSION['success'] = 'Evento eliminado';
    } else {
      $_SESSION['error'] = 'Error: ' . $e->getError();
    }
    header('Location: eventos.php');
    exit();
  }

  public function detalles(int $id)
  {
    $model = new Evento();
    $evento = method_exists($model, 'findById') ? $model->findById($id) : $model->find($id);

    if (!$evento) {
      $_SESSION['eventos_error'] = 'Evento no encontrado.';
      header('Location: eventos.php');
      exit();
    }

    $e = $evento; 
    require __DIR__ . '/../views/Eventos/detalles.php';
  }

  public function asistir(int $evento_id)
  {
    require_login();

    if (($_SESSION['rol'] ?? '') !== 'usuario') {
      $_SESSION['eventos_error'] = 'Solo los usuarios pueden registrarse a eventos';
      header('Location: eventos.php?action=detalles&id=' . $evento_id);
      exit();
    }

    $asistenciaModel = new EventoAsistencia();
    $eventoModel = new Evento();

    $evento = $eventoModel->find($evento_id);
    if (!$evento || !in_array($evento['estado'], ['Planificado', 'En curso'])) {
      $_SESSION['eventos_error'] = 'No se puede registrar a este evento';
      header('Location: eventos.php');
      exit();
    }

    if ($asistenciaModel->registrarAsistencia($evento_id, (int) $_SESSION['user_id'])) {
      $_SESSION['eventos_success'] = '¡Registro exitoso! Te esperamos en el evento';
    } else {
      $_SESSION['eventos_error'] = $asistenciaModel->getError() ?? 'Error al registrar asistencia';
    }

    header('Location: eventos.php?action=detalles&id=' . $evento_id);
    exit();
  }
}