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

//   public function edit(int $id)
//   {
//     require_role(['admin', 'voluntario']); // Permitir a voluntarios editar
//     $u = new Usuario();
//     $usuario = $u->find($id);
//     if (!$usuario) {
//       header('Location: eventos.php');
//       exit();
//     }

//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//       $data = [
//         'nombre' => $_POST['nombre'] ?? '',
//         'apellido' => $_POST['apellido'] ?? '',
//         'email' => $_POST['email'] ?? '',
//         'telefono' => $_POST['telefono'] ?? ''
//       ];
//       if ($u->update($id, $data)) {
//         $_SESSION['success'] = 'Evento actualizado';
//       } else {
//         $_SESSION['error'] = 'Error: ' . $u->getError();
//       }
//       header('Location: usuarios.php');
//       exit();
//     }
//     require 'app/views/Usuarios/edit.php';
//   }

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