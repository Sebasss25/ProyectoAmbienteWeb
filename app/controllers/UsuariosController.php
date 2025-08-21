<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../models/Usuario.php';

class UsuariosController
{
  public function index()
  {
    require_login();
    $u = new Usuario();
    $usuarios = $u->all();
    require 'app/views/Usuarios/index.php';
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
    $u = new Usuario();
    if ($u->delete($id)) {
      $_SESSION['success'] = 'Usuario eliminado';
    } else {
      $_SESSION['error'] = 'Error: ' . $u->getError();
    }
    header('Location: usuarios.php');
    exit();
  }

public function search(string $email)
  {
    require_role(['admin']);
    $u = new Usuario();
    $usuario = $u->findByEmail($email);

    if ($usuario) {
        $usuarios = [$usuario];
        $_SESSION['success'] = 'Usuario encontrado';
    } else {
        $usuarios = [];
        $_SESSION['error'] = 'No se encontró un usuario con ese correo';
    }

    require 'app/views/Usuarios/index.php';
  }
}