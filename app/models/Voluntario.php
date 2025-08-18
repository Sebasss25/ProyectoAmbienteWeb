<?php
require_once __DIR__ . '/BaseModel.php';

class Voluntario extends BaseModel {
  public function all(): array {
    $sql = 'SELECT v.id AS id_voluntario,
       u.nombre, u.apellido, u.email,
       v.fechaInicio, v.fechaFin, v.horas, v.estado
      FROM Voluntarios v
      JOIN Usuarios u ON u.id = v.usuario
      ORDER BY v.id DESC;';
    $res = $this->db->query($sql);
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  }
  public function find(int $id): ?array {
    $stmt = $this->db->prepare('SELECT * FROM Usuarios WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    return $row ?: null;
  }


    public function delete(int $id): bool {
    $stmt = $this->db->prepare('DELETE FROM Voluntarios WHERE id=?');
    $stmt->bind_param('i', $id);
    $ok = $stmt->execute();
    if(!$ok){ $this->error = $stmt->error; }
    return $ok;
  }

}
