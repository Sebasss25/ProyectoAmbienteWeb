<?php
require_once __DIR__ . '/BaseModel.php';

class TareaVoluntario extends BaseModel {

  public function porVoluntario(int $voluntarioId): array {
    $stmt = $this->db->prepare(
      'SELECT * FROM TareasVoluntariado
       WHERE voluntario = ?
       ORDER BY
         CASE estado
           WHEN "Pendiente" THEN 1
           WHEN "En progreso" THEN 2
           WHEN "Completada" THEN 3
         END,
         COALESCE(fecha_limite, "9999-12-31") ASC,
         id DESC'
    );
    $stmt->bind_param('i', $voluntarioId);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  }

  public function find(int $id): ?array {
    $stmt = $this->db->prepare('SELECT * FROM TareasVoluntariado WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    return $row ?: null;
  }

  public function create(array $d): bool {
    $sql = 'INSERT INTO TareasVoluntariado
            (voluntario, titulo, descripcion, fecha_limite, estado, prioridad)
            VALUES (?,?,?,?,?,?)';
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param(
      'isssss',
      $d['voluntario'], $d['titulo'], $d['descripcion'],
      $d['fecha_limite'], $d['estado'], $d['prioridad']
    );
    $ok = $stmt->execute();
    if (!$ok) { $this->error = $stmt->error; }
    return $ok;
  }

  public function update(int $id, array $d): bool {
    $sql = 'UPDATE TareasVoluntariado
            SET titulo=?, descripcion=?, fecha_limite=?, estado=?, prioridad=?
            WHERE id=?';
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param(
      'sssssi',
      $d['titulo'], $d['descripcion'], $d['fecha_limite'],
      $d['estado'], $d['prioridad'], $id
    );
    $ok = $stmt->execute();
    if (!$ok) { $this->error = $stmt->error; }
    return $ok;
  }

  public function delete(int $id): bool {
    $stmt = $this->db->prepare('DELETE FROM TareasVoluntariado WHERE id=?');
    $stmt->bind_param('i', $id);
    $ok = $stmt->execute();
    if (!$ok) { $this->error = $stmt->error; }
    return $ok;
  }
}
