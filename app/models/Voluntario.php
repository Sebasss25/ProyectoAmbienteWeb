<?php
require_once __DIR__ . '/BaseModel.php';

class Voluntario extends BaseModel {

  public function all(): array {
    $sql = 'SELECT v.id AS id_voluntario,
                   u.id AS id_usuario,
                   u.nombre, u.apellido, u.email,
                   v.fechaInicio, v.fechaFin, v.horas, v.estado
            FROM Voluntarios v
            JOIN Usuarios u ON u.id = v.usuario
            ORDER BY v.id DESC;';
    $res = $this->db->query($sql);
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  }

  /** Detalle por ID de voluntario (con datos del usuario) */
  public function getById(int $idVoluntario): ?array {
    $stmt = $this->db->prepare(
      'SELECT v.id AS id_voluntario, v.usuario AS id_usuario,
              u.nombre, u.apellido, u.email,
              v.fechaInicio, v.fechaFin, v.horas, v.estado
       FROM Voluntarios v
       JOIN Usuarios u ON u.id = v.usuario
       WHERE v.id = ?'
    );
    $stmt->bind_param('i', $idVoluntario);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    return $row ?: null;
  }

  /** Obtener id de voluntario por id de usuario (si existe uno cualquiera, preferible el activo) */
  public function getByUsuario(int $usuarioId): ?int {
    // primero activo
    $stmt = $this->db->prepare('SELECT id FROM Voluntarios WHERE usuario = ? AND estado = "Activo" LIMIT 1');
    $stmt->bind_param('i', $usuarioId);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if ($row) return (int)$row['id'];

    // luego cualquiera
    $stmt = $this->db->prepare('SELECT id FROM Voluntarios WHERE usuario = ? ORDER BY id DESC LIMIT 1');
    $stmt->bind_param('i', $usuarioId);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    return $row ? (int)$row['id'] : null;
  }

  public function search(string $estado): array {
    $stmt = $this->db->prepare(
      'SELECT v.id AS id_voluntario,
              u.nombre, u.apellido, u.email,
              v.fechaInicio, v.fechaFin, v.horas, v.estado
       FROM Voluntarios v
       JOIN Usuarios u ON u.id = v.usuario
       WHERE v.estado LIKE ?'
    );
    $like = "%$estado%";
    $stmt->bind_param('s', $like);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  }

  public function delete(int $id): bool {
    $stmt = $this->db->prepare('DELETE FROM Voluntarios WHERE id=?');
    $stmt->bind_param('i', $id);
    $ok = $stmt->execute();
    if(!$ok){ $this->error = $stmt->error; }
    return $ok;
  }

  /* ====== NUEVO: Activar / Finalizar voluntariado ====== */

  /** ¿Tiene voluntariado ACTIVO este usuario? */
  public function existsActivoByUsuario(int $usuarioId): bool {
    $stmt = $this->db->prepare('SELECT 1 FROM Voluntarios WHERE usuario=? AND estado="Activo" LIMIT 1');
    $stmt->bind_param('i', $usuarioId);
    $stmt->execute();
    return (bool)$stmt->get_result()->fetch_row();
  }

  /** Activar voluntariado para un usuario (crea fila) */
  public function activarParaUsuario(int $usuarioId): bool {
    if ($this->existsActivoByUsuario($usuarioId)) {
      $this->error = 'El usuario ya tiene un voluntariado activo.';
      return false;
    }
    $stmt = $this->db->prepare(
      'INSERT INTO Voluntarios (usuario, fechaInicio, fechaFin, horas, estado)
       VALUES (?, NOW(), NULL, 0, "Activo")'
    );
    $stmt->bind_param('i', $usuarioId);
    $ok = $stmt->execute();
    if(!$ok){ $this->error = $stmt->error; }
    return $ok;
  }

  /** Finalizar voluntariado (poner Inactivo y fechaFin = NOW()) */
  public function inactivar(int $idVoluntario): bool {
    $stmt = $this->db->prepare(
      'UPDATE Voluntarios
         SET estado="Inactivo", fechaFin = NOW()
       WHERE id=? AND estado="Activo"'
    );
    $stmt->bind_param('i', $idVoluntario);
    $ok = $stmt->execute();
    if(!$ok){ $this->error = $stmt->error; }
    return $ok;
  }
}
