<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../models/Voluntario.php';
require_once __DIR__ . '/../models/TareaVoluntario.php';
require_once __DIR__ . '/../models/Usuario.php';

class VoluntariosController
{
  public function index()
  {
    require_login();
    $v = new Voluntario();
    $voluntarios = $v->all();
    require 'app/views/Voluntarios/index.php';
  }

  public function search(string $estado)
  {
    require_login();
    $v = new Voluntario();
    $voluntarios = $v->search($estado);

    if ($voluntarios && count($voluntarios) > 0) {
      $_SESSION['voluntarios_success'] = 'Voluntarios encontrados';
    } else {
      $voluntarios = [];
      $_SESSION['error'] = 'No se encontraron voluntarios con ese estado';
    }

    require 'app/views/Voluntarios/index.php';
  }

  public function delete(int $id)
  {
    require_role(['admin']);
    $v = new Voluntario();
    if ($v->delete($id)) {
      $_SESSION['success'] = 'Voluntario eliminado';
    } else {
      $_SESSION['error'] = 'Error: ' . $v->getError();
    }
    header('Location: voluntarios.php');
    exit();
  }


  public function activar_select()
  {
    require_role(['admin']);
    $u = new Usuario();
    $candidatos = $u->voluntariosElegibles();
    require 'app/views/Voluntarios/activar_select.php';
  }

  public function activar(int $usuarioId)
  {
    require_role(['admin']);
    $v = new Voluntario();
    if ($v->activarParaUsuario($usuarioId)) {
      $_SESSION['success'] = 'Voluntariado activado.';
    } else {
      $_SESSION['error'] = 'Error: ' . $v->getError();
    }
    header('Location: voluntarios.php');
    exit();
  }

  public function inactivar(int $voluntarioId)
  {
    require_role(['admin']);
    $v = new Voluntario();
    if ($v->inactivar($voluntarioId)) {
      $_SESSION['success'] = 'Voluntariado finalizado.';
    } else {
      $_SESSION['error'] = 'Error: ' . $v->getError();
    }
    header('Location: voluntarios.php');
    exit();
  }


  public function tareas(int $voluntarioId)
  {
    require_role(['admin']);
    $vModel = new Voluntario();
    $info   = $vModel->getById($voluntarioId);
    if (!$info) {
      $_SESSION['error'] = 'Voluntario no encontrado';
      header('Location: voluntarios.php'); exit();
    }

    $tModel = new TareaVoluntario();
    $tareas = $tModel->porVoluntario($voluntarioId);
    require 'app/views/Voluntarios/tareas_index.php';
  }

  public function tarea_create(int $voluntarioId)
  {
    require_role(['admin']);
    $vModel = new Voluntario();
    $info   = $vModel->getById($voluntarioId);
    if (!$info) {
      $_SESSION['error'] = 'Voluntario no encontrado';
      header('Location: voluntarios.php'); exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $d = [
        'voluntario'   => $voluntarioId,
        'titulo'       => trim($_POST['titulo'] ?? ''),
        'descripcion'  => trim($_POST['descripcion'] ?? ''),
        'fecha_limite' => $_POST['fecha_limite'] ?: null,
        'estado'       => $_POST['estado'] ?? 'Pendiente',
        'prioridad'    => $_POST['prioridad'] ?? 'Media',
      ];
      $tModel = new TareaVoluntario();
      if ($tModel->create($d)) {
        $_SESSION['success'] = 'Tarea creada';
        header("Location: voluntarios.php?action=tareas&id={$voluntarioId}");
      } else {
        $_SESSION['error'] = 'Error: ' . $tModel->getError();
        header("Location: voluntarios.php?action=tarea_create&id={$voluntarioId}");
      }
      exit();
    }

    require 'app/views/Voluntarios/tareas_create.php';
  }

  public function tarea_edit(int $tareaId, int $voluntarioId)
  {
    require_role(['admin']);
    $tModel = new TareaVoluntario();
    $tarea  = $tModel->find($tareaId);
    if (!$tarea || (int)$tarea['voluntario'] !== (int)$voluntarioId) {
      $_SESSION['error'] = 'Tarea no encontrada';
      header("Location: voluntarios.php?action=tareas&id={$voluntarioId}"); exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $d = [
        'titulo'       => trim($_POST['titulo'] ?? ''),
        'descripcion'  => trim($_POST['descripcion'] ?? ''),
        'fecha_limite' => $_POST['fecha_limite'] ?: null,
        'estado'       => $_POST['estado'] ?? 'Pendiente',
        'prioridad'    => $_POST['prioridad'] ?? 'Media',
      ];
      if ($tModel->update($tareaId, $d)) {
        $_SESSION['success'] = 'Tarea actualizada';
      } else {
        $_SESSION['error'] = 'Error: ' . $tModel->getError();
      }
      header("Location: voluntarios.php?action=tareas&id={$voluntarioId}");
      exit();
    }

    require 'app/views/Voluntarios/tareas_edit.php';
  }

  public function tarea_delete(int $tareaId, int $voluntarioId)
  {
    require_role(['admin']);
    $tModel = new TareaVoluntario();
    if ($tModel->delete($tareaId)) {
      $_SESSION['success'] = 'Tarea eliminada';
    } else {
      $_SESSION['error'] = 'Error: ' . $tModel->getError();
    }
    header("Location: voluntarios.php?action=tareas&id={$voluntarioId}");
    exit();
  }

  public function mis_tareas()
  {
    require_role(['voluntario']);
    $usuarioId = (int)($_SESSION['user_id'] ?? 0);

    $vModel = new Voluntario();
    $voluntarioId = $vModel->getByUsuario($usuarioId);
    if (!$voluntarioId) {
      $_SESSION['error'] = 'No tienes un voluntariado activo.';
      header('Location: voluntarios.php'); exit();
    }

    $tModel = new TareaVoluntario();
    $tareas = $tModel->porVoluntario($voluntarioId);
    require 'app/views/Voluntarios/mis_tareas.php';
  }
}
