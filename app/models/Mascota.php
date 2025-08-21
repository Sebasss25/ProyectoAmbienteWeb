<?php
require_once __DIR__ . '/BaseModel.php';

class Mascota extends BaseModel {

  public function all(): array {
    $sql = 'SELECT m.*, CONCAT(u.nombre, " ", u.apellido) AS propietario
            FROM Mascotas m JOIN Usuarios u ON m.usuario=u.id
            ORDER BY m.id DESC';
    $res = $this->db->query($sql);
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  }

  public function findById(int $id) {
    $stmt = $this->db->prepare("SELECT * FROM Mascotas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
  }

  public function find(int $id): ?array {
    $stmt = $this->db->prepare('SELECT * FROM Mascotas WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    return $row ?: null;
  }
    public function setEstado(int $id, string $estado): bool {
    $stmt = $this->db->prepare('UPDATE Mascotas SET estado=? WHERE id=?');
    $stmt->bind_param('si', $estado, $id);
    $ok = $stmt->execute();
    if(!$ok){ $this->error = $stmt->error; }
    return $ok;
  }



  public function create(array $d): bool {
    $stmt = $this->db->prepare('INSERT INTO Mascotas(nombre,raza,edad,descripcion,foto,estado,usuario) VALUES (?,?,?,?,?,?,?)');
    $stmt->bind_param('ssisssi', $d['nombre'],$d['raza'],$d['edad'],$d['descripcion'],$d['foto'],$d['estado'],$d['usuario']);
    $ok = $stmt->execute();
    if(!$ok){ $this->error = $stmt->error; }
    return $ok;
  }

  public function update(int $id, array $d): bool {
    $stmt = $this->db->prepare('UPDATE Mascotas SET nombre=?, raza=?, edad=?, descripcion=?, foto=?, estado=?, usuario=? WHERE id=?');
    $stmt->bind_param('ssisssii', $d['nombre'],$d['raza'],$d['edad'],$d['descripcion'],$d['foto'],$d['estado'],$d['usuario'],$id);
    $ok = $stmt->execute();
    if(!$ok){ $this->error = $stmt->error; }
    return $ok;
  }

  public function delete(int $id): bool {
    $stmt = $this->db->prepare('DELETE FROM Mascotas WHERE id=?');
    $stmt->bind_param('i', $id);
    $ok = $stmt->execute();
    if(!$ok){ $this->error = $stmt->error; }
    return $ok;
  }

  public function disponibles(int $limit = 50): array {
    $stmt = $this->db->prepare(
      'SELECT id, nombre, raza, edad, foto, estado
       FROM Mascotas
       WHERE estado = "Disponible"
       ORDER BY id DESC
       LIMIT ?'
    );
    $stmt->bind_param('i', $limit);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  }
  public function updateConResetAdopciones(int $id, array $d): bool {
    $this->db->begin_transaction();
    try {
      // 1) Bloquear la mascota y leer estado anterior
      $stmt = $this->db->prepare('SELECT estado FROM Mascotas WHERE id=? FOR UPDATE');
      $stmt->bind_param('i', $id);
      $stmt->execute();
      $res  = $stmt->get_result();
      $row  = $res->fetch_assoc();

      if (!$row) { throw new Exception('Mascota no encontrada'); }

      $estadoAnterior = $row['estado'];

      // 2) Actualizar mascota
      $stmt = $this->db->prepare('UPDATE Mascotas
        SET nombre=?, raza=?, edad=?, descripcion=?, foto=?, estado=?, usuario=?
        WHERE id=?');
      $stmt->bind_param(
        'ssisssii',
        $d['nombre'],$d['raza'],$d['edad'],$d['descripcion'],$d['foto'],$d['estado'],$d['usuario'],$id
      );
      if (!$stmt->execute()) { throw new Exception($stmt->error); }

      // 3) Si pasó a "Disponible" desde Adoptado o En comunicación => borrar adopciones
      if ($d['estado'] === 'Disponible' && in_array($estadoAnterior, ['Adoptado','En comunicación'], true)) {
        $stmt = $this->db->prepare('DELETE FROM Adopciones WHERE mascota=?');
        $stmt->bind_param('i', $id);
        if (!$stmt->execute()) { throw new Exception($stmt->error); }
      }

      $this->db->commit();
      return true;

    } catch (Throwable $e) {
      $this->db->rollback();
      $this->error = $e->getMessage();
      return false;
    }
  }

}
