<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../models/Voluntario.php';

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
}