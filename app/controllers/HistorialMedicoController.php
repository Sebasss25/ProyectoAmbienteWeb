<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../models/HistorialMedico.php';
require_once __DIR__ . '/../models/Mascota.php';

class HistorialMedicoController {

  private function puedeEditar(): bool {
    $rol = $_SESSION['rol'] ?? 'usuario';
    return in_array($rol, ['admin', 'voluntario'], true);
  }

  public function index(int $mascotaId) {
    require_login();

    $mModel = new Mascota();
    $mascota = $mModel->find($mascotaId);
    if (!$mascota) {
      $_SESSION['mascotas_error'] = 'Mascota no encontrada.';
      header('Location: mascotas.php'); exit();
    }

    $hModel = new HistorialMedico();
    $items = $hModel->porMascota($mascotaId); 
    $puedeEditar = $this->puedeEditar();

    require 'app/views/historial/index.php';
  }

  public function create(int $mascotaId) {
    require_login();
    if (!$this->puedeEditar()) {
      $_SESSION['error'] = 'No autorizado.'; 
      header("Location: historial.php?mascota_id=$mascotaId"); exit();
    }

    $mModel = new Mascota();
    $mascota = $mModel->find($mascotaId);
    if (!$mascota) {
      $_SESSION['mascotas_error'] = 'Mascota no encontrada.';
      header('Location: mascotas.php'); exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $activo = isset($_POST['activo']) ? (int)$_POST['activo'] : 1;

      $d = [
        'mascota'         => $mascotaId,
        'fecha_consulta'  => $_POST['fecha_consulta'] ?? date('Y-m-d'),
        'motivo'          => trim($_POST['motivo'] ?? ''),
        'diagnostico'     => trim($_POST['diagnostico'] ?? ''),
        'tratamiento'     => trim($_POST['tratamiento'] ?? ''),
        'veterinario'     => trim($_POST['veterinario'] ?? ''),
        'peso_kg'         => strlen($_POST['peso_kg'] ?? '') ? (float)$_POST['peso_kg'] : null,
        'temperatura_c'   => strlen($_POST['temperatura_c'] ?? '') ? (float)$_POST['temperatura_c'] : null,
        'observaciones'   => trim($_POST['observaciones'] ?? ''),
        'proximo_control' => $_POST['proximo_control'] ?: null,
        'adjunto_url'     => trim($_POST['adjunto_url'] ?? ''),
        'activo'          => $activo
      ];

      $hModel = new HistorialMedico();
      if ($hModel->create($d)) {
        if ($activo === 1) {
          $mModel->setEstado($mascotaId, 'En tratamiento');
        } else {
          $mModel->setEstado($mascotaId, 'Disponible');
        }

        $_SESSION['success'] = 'Registro médico creado.';
        header("Location: historial.php?mascota_id={$mascotaId}");
      } else {
        $_SESSION['error'] = 'Error: ' . $hModel->getError();
        header("Location: historial.php?action=create&mascota_id={$mascotaId}");
      }
      exit();
    }

    require 'app/views/historial/create.php';
  }

  public function edit(int $id, int $mascotaId) {
    require_login();
    if (!$this->puedeEditar()) {
      $_SESSION['error'] = 'No autorizado.'; 
      header("Location: historial.php?mascota_id=$mascotaId"); exit();
    }

    $mModel = new Mascota();
    $mascota = $mModel->find($mascotaId);
    if (!$mascota) {
      $_SESSION['mascotas_error'] = 'Mascota no encontrada.';
      header('Location: mascotas.php'); exit();
    }

    $hModel = new HistorialMedico();
    $item = $hModel->find($id);
    if (!$item || (int)$item['mascota'] !== (int)$mascotaId) {
      $_SESSION['error'] = 'Registro no encontrado.';
      header("Location: historial.php?mascota_id=$mascotaId"); exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $activo = isset($_POST['activo']) ? (int)$_POST['activo'] : (int)($item['activo'] ?? 1);

      $d = [
        'fecha_consulta'  => $_POST['fecha_consulta'] ?? $item['fecha_consulta'],
        'motivo'          => trim($_POST['motivo'] ?? ''),
        'diagnostico'     => trim($_POST['diagnostico'] ?? ''),
        'tratamiento'     => trim($_POST['tratamiento'] ?? ''),
        'veterinario'     => trim($_POST['veterinario'] ?? ''),
        'peso_kg'         => strlen($_POST['peso_kg'] ?? '') ? (float)$_POST['peso_kg'] : null,
        'temperatura_c'   => strlen($_POST['temperatura_c'] ?? '') ? (float)$_POST['temperatura_c'] : null,
        'observaciones'   => trim($_POST['observaciones'] ?? ''),
        'proximo_control' => $_POST['proximo_control'] ?: null,
        'adjunto_url'     => trim($_POST['adjunto_url'] ?? ''),
        'activo'          => $activo
      ];

      if ($hModel->update($id, $d)) {
        if ($activo === 1) {
          $mModel->setEstado($mascotaId, 'En tratamiento');
        } else {
          $mModel->setEstado($mascotaId, 'Disponible');
        }

        $_SESSION['success'] = 'Registro médico actualizado.';
      } else {
        $_SESSION['error'] = 'Error: ' . $hModel->getError();
      }
      header("Location: historial.php?mascota_id={$mascotaId}");
      exit();
    }

    require 'app/views/historial/edit.php';
  }

  public function delete(int $id, int $mascotaId) {
    require_login();
    if (!$this->puedeEditar()) {
      $_SESSION['error']='No autorizado.'; 
      header("Location: historial.php?mascota_id=$mascotaId"); exit();
    }

    $hModel = new HistorialMedico();
    if ($hModel->delete($id)) {
      $_SESSION['success'] = 'Registro médico eliminado.';
    } else {
      $_SESSION['error'] = 'Error: ' . $hModel->getError();
    }
    header("Location: historial.php?mascota_id={$mascotaId}");
    exit();
  }
}
