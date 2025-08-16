<?php
require_once __DIR__ . '/BaseModel.php';

class Evento extends BaseModel {
  public function all(): array {
    $sql = 'SELECT e.*, CONCAT(u.nombre, " ", u.apellido) AS responsable_nombre
            FROM Eventos e JOIN Usuarios u ON e.responsable=u.id
            ORDER BY e.id DESC';
    $res = $this->db->query($sql);
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  }
  
  public function findById(int $id) {
    $stmt = $this->db->prepare("SELECT * FROM Eventos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
  }

  public function find(int $id): ?array {
    $stmt = $this->db->prepare('SELECT * FROM Eventos WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    return $row ?: null;
  }

  public function create(array $d): bool {
    $stmt = $this->db->prepare('INSERT INTO Eventos(nombre,descripcion,fecha,ubicacion,responsable,tipo,estado) VALUES (?,?,?,?,?,?,?)');
    $stmt->bind_param('ssssiss', $d['nombre'],$d['descripcion'],$d['fecha'],$d['ubicacion'],$d['responsable'],$d['tipo'],$d['estado']);
    $ok = $stmt->execute();
    if(!$ok){ $this->error = $stmt->error; }
    return $ok;
  }

  public function update(int $id, array $d): bool {
    $stmt = $this->db->prepare('UPDATE Eventos SET nombre=?, descripcion=?, fecha=?, ubicacion=?, responsable=?, tipo=?, estado=? WHERE id=?');
    $stmt->bind_param('ssssissi', $d['nombre'],$d['descripcion'],$d['fecha'],$d['ubicacion'],$d['responsable'],$d['tipo'],$d['estado'],$id);
    $ok = $stmt->execute();
    if(!$ok){ $this->error = $stmt->error; }
    return $ok;
  }

  public function delete(int $id): bool {
    $stmt = $this->db->prepare('DELETE FROM Eventos WHERE id=?');
    $stmt->bind_param('i', $id);
    $ok = $stmt->execute();
    if(!$ok){ $this->error = $stmt->error; }
    return $ok;
  }
  
  public function disponibles(int $limit = 50): array {
    $stmt = $this->db->prepare(
        'SELECT id, nombre, descripcion, fecha, ubicacion, tipo, estado
        FROM Eventos
        WHERE estado IN ("En curso", "Planificado")
        ORDER BY fecha ASC
        LIMIT ?'
    );
    $stmt->bind_param('i', $limit);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  }
}