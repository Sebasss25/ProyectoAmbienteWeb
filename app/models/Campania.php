<?php
require_once __DIR__ . '/BaseModel.php';

class Campania extends BaseModel
{
  public function all(): array
  {
    $sql = 'SELECT c.*, CONCAT(u.nombre, " ", u.apellido) AS responsable
            FROM Campanias c JOIN Usuarios u ON c.usuario=u.id
            ORDER BY c.id DESC';
    $res = $this->db->query($sql);
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  }

  public function findById(int $id)
  {
    $stmt = $this->db->prepare("SELECT * FROM Campanias WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
  }

  public function find(int $id): ?array
  {
    $stmt = $this->db->prepare('SELECT * FROM Campanias WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc(); // Esto retorna un array asociativo 
  }

  public function create(array $d): bool
  {
    $stmt = $this->db->prepare('INSERT INTO Campanias(nombre,descripcion,fechaInicio,fechaFin,objetivo,estado,usuario) VALUES (?,?,?,?,?,?,?)');
    $stmt->bind_param('ssssdsi', $d['nombre'], $d['descripcion'], $d['fechaInicio'], $d['fechaFin'], $d['objetivo'], $d['estado'], $d['usuario']);
    $ok = $stmt->execute();
    if (!$ok) {
      $this->error = $stmt->error;
    }
    return $ok;
  }

  public function update(int $id, array $d): bool
  {
    $stmt = $this->db->prepare('UPDATE Campanias SET nombre=?, descripcion=?, fechaInicio=?, fechaFin=?, objetivo=?, estado=? WHERE id=?');
    $stmt->bind_param(
      'ssssdsi',
      $d['nombre'],
      $d['descripcion'],
      $d['fechaInicio'],
      $d['fechaFin'],
      $d['objetivo'],
      $d['estado'],
      $id
    );

    try {
      $ok = $stmt->execute();
      if (!$ok) {
        $this->error = $stmt->error;
      }
      return $ok;
    } catch (mysqli_sql_exception $e) {
      $this->error = $e->getMessage();
      return false;
    }
  }

  public function delete(int $id): bool
  {
    $stmt = $this->db->prepare('DELETE FROM Campanias WHERE id=?');
    $stmt->bind_param('i', $id);
    $ok = $stmt->execute();
    if (!$ok) {
      $this->error = $stmt->error;
    }
    return $ok;
  }

  public function activas(int $limit = 50): array
  {
    $stmt = $this->db->prepare(
      'SELECT id, nombre, descripcion, fechaInicio, fechaFin, objetivo, estado
        FROM Campanias
        WHERE estado = "Activa"
        ORDER BY id DESC
        LIMIT ?'
    );
    $stmt->bind_param('i', $limit);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  }
}