<?php
require_once __DIR__ . '/BaseModel.php';

class HistorialMedico extends BaseModel {

  public function porMascota(int $mascotaId): array {
    $stmt = $this->db->prepare(
      'SELECT 
         id, mascota, fecha_consulta, motivo, diagnostico, tratamiento,
         veterinario, peso_kg, temperatura_c, observaciones,
         proximo_control, adjunto_url, activo,
         created_at, updated_at
       FROM HistorialMedico
       WHERE mascota = ?
       ORDER BY fecha_consulta DESC, id DESC'
    );
    $stmt->bind_param('i', $mascotaId);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  }

  public function find(int $id): ?array {
    $stmt = $this->db->prepare(
      'SELECT 
         id, mascota, fecha_consulta, motivo, diagnostico, tratamiento,
         veterinario, peso_kg, temperatura_c, observaciones,
         proximo_control, adjunto_url, activo,
         created_at, updated_at
       FROM HistorialMedico
       WHERE id = ?'
    );
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    return $row ?: null;
  }

  public function create(array $d): bool {
    $peso   = isset($d['peso_kg']) && $d['peso_kg'] !== '' ? $d['peso_kg'] : null;
    $temp   = isset($d['temperatura_c']) && $d['temperatura_c'] !== '' ? $d['temperatura_c'] : null;
    $prox   = isset($d['proximo_control']) && $d['proximo_control'] !== '' ? $d['proximo_control'] : null;

    $sql = 'INSERT INTO HistorialMedico
              (mascota, fecha_consulta, motivo, diagnostico, tratamiento,
               veterinario, peso_kg, temperatura_c, observaciones,
               proximo_control, adjunto_url, activo)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?)';
    $stmt = $this->db->prepare($sql);

    $types = 'isssssddsssi';

    $mascota = (int)$d['mascota'];
    $fecha   = $d['fecha_consulta'];
    $motivo  = $d['motivo'];
    $diag    = $d['diagnostico'] ?? '';
    $trat    = $d['tratamiento'] ?? '';
    $vet     = $d['veterinario'] ?? '';
    $obs     = $d['observaciones'] ?? '';
    $adj     = $d['adjunto_url'] ?? '';
    $activo  = (int)($d['activo'] ?? 1);

    $stmt->bind_param(
      $types,
      $mascota, $fecha, $motivo, $diag, $trat, $vet,
      $peso, $temp, $obs, $prox, $adj, $activo
    );

    $ok = $stmt->execute();
    if (!$ok) { $this->error = $stmt->error; }
    return $ok;
  }

  public function update(int $id, array $d): bool {
    $peso   = isset($d['peso_kg']) && $d['peso_kg'] !== '' ? $d['peso_kg'] : null;
    $temp   = isset($d['temperatura_c']) && $d['temperatura_c'] !== '' ? $d['temperatura_c'] : null;
    $prox   = isset($d['proximo_control']) && $d['proximo_control'] !== '' ? $d['proximo_control'] : null;
    $activo = (int)($d['activo'] ?? 1);

    $sql = 'UPDATE HistorialMedico
              SET fecha_consulta=?,
                  motivo=?,
                  diagnostico=?,
                  tratamiento=?,
                  veterinario=?,
                  peso_kg=?,
                  temperatura_c=?,
                  observaciones=?,
                  proximo_control=?,
                  adjunto_url=?,
                  activo=?
            WHERE id=?';

    $stmt  = $this->db->prepare($sql);

    $types = 'sssssddsssii';

    $fecha = $d['fecha_consulta'];
    $motivo = $d['motivo'] ?? '';
    $diag   = $d['diagnostico'] ?? '';
    $trat   = $d['tratamiento'] ?? '';
    $vet    = $d['veterinario'] ?? '';
    $obs    = $d['observaciones'] ?? '';
    $adj    = $d['adjunto_url'] ?? '';

    $stmt->bind_param(
      $types,
      $fecha, $motivo, $diag, $trat, $vet,
      $peso, $temp, $obs, $prox, $adj, $activo, $id
    );

    $ok = $stmt->execute();
    if (!$ok) { $this->error = $stmt->error; }
    return $ok;
  }

  public function delete(int $id): bool {
    $stmt = $this->db->prepare('DELETE FROM HistorialMedico WHERE id=?');
    $stmt->bind_param('i', $id);
    $ok = $stmt->execute();
    if (!$ok) { $this->error = $stmt->error; }
    return $ok;
  }
}
