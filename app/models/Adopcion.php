<?php
require_once __DIR__ . '/BaseModel.php';

class Adopcion extends BaseModel {

  public function crearSolicitud(array $d): bool {
    $this->db->begin_transaction();
    try {
      // 1) Bloquear la mascota
      $stmt = $this->db->prepare('SELECT id, estado FROM Mascotas WHERE id=? FOR UPDATE');
      $stmt->bind_param('i', $d['mascota']);
      $stmt->execute();
      $res = $stmt->get_result();
      $row = $res->fetch_assoc();

      if (!$row) {
        throw new Exception('Mascota no encontrada');
      }
      if ($row['estado'] !== 'Disponible') {
        throw new Exception('Mascota no disponible');
      }

      // 2) Insertar adopción
      $stmt = $this->db->prepare('INSERT INTO Adopciones (fecha, usuario, mascota) VALUES (NOW(), ?, ?)');
      $stmt->bind_param('ii', $d['usuario'], $d['mascota']);
      if (!$stmt->execute()) {
        throw new Exception($stmt->error);
      }

      // 3) Cambiar estado a 'En comunicación'
      $nuevoEstado = 'En comunicación';
      $stmt = $this->db->prepare('UPDATE Mascotas SET estado=? WHERE id=?');
      $stmt->bind_param('si', $nuevoEstado, $d['mascota']);
      if (!$stmt->execute()) {
        throw new Exception($stmt->error);
      }

      // 4) Log opcional
      $mensaje = "Solicitud adopción: usuario={$d['usuario']} mascota={$d['mascota']} motivo={$d['motivo']} experiencia={$d['experiencia']} contacto={$d['contacto']}\n";
      @file_put_contents(__DIR__ . '/../../storage/adopciones.log', $mensaje, FILE_APPEND);

      // 5) Commit
      $this->db->commit();
      return true;

    } catch (Throwable $e) {
      $this->db->rollback();
      $this->error = $e->getMessage();
      return false;
    }
  }
}
