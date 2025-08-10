<?php
require_once __DIR__ . '/BaseModel.php';

class Usuario extends BaseModel {
  public function findByEmail(string $email): ?array {
    $stmt = $this->db->prepare(
      'SELECT u.*, r.nombre AS rol_nombre
       FROM Usuarios u
       JOIN Roles r ON u.rol = r.id
       WHERE u.email = ? LIMIT 1'
    );
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    return $res ?: null;
  }

  public function create(array $d): bool {
    $stmt = $this->db->prepare(
      'INSERT INTO Usuarios (nombre, apellido, email, password, telefono, rol)
       VALUES (?,?,?,?,?,?)'
    );
    $stmt->bind_param(
      'sssssi',
      $d['nombre'], $d['apellido'], $d['email'], $d['password'], $d['telefono'], $d['rol']
    );
    $ok = $stmt->execute();
    if (!$ok) { $this->error = $stmt->error; }
    return $ok;
  }
}
