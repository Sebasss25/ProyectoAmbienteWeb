<?php
require_once __DIR__ . '/BaseModel.php';

class Usuario extends BaseModel {

  public function all(): array {
    $sql = 'SELECT u.*, r.nombre AS rol_nombre
            FROM Usuarios u
            LEFT JOIN Roles r ON u.rol = r.id
            ORDER BY u.id DESC';
    $res = $this->db->query($sql);
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
  }

  public function find(int $id): ?array {
    $stmt = $this->db->prepare(
      'SELECT u.*, r.nombre AS rol_nombre
       FROM Usuarios u
       LEFT JOIN Roles r ON u.rol = r.id
       WHERE u.id = ?'
    );
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    return $row ?: null;
  }

  public function findByEmail(string $email): ?array {
    $stmt = $this->db->prepare(
      'SELECT u.*, r.nombre AS rol_nombre
       FROM Usuarios u
       LEFT JOIN Roles r ON u.rol = r.id
       WHERE u.email = ? LIMIT 1'
    );
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    return $res ?: null;
  }

  public function rolesDisponibles(): array {
    // Filtramos a los 3 roles que mencionaste (orden alfabético)
    $sql = "SELECT id, nombre
            FROM Roles
            WHERE nombre IN ('Administrador','Usuario','Voluntario')
            ORDER BY nombre";
    $res = $this->db->query($sql);
    return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
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

  public function update(int $id, array $d): bool {
    // Aquí NO se actualiza password (no fue solicitado).
    $stmt = $this->db->prepare(
      'UPDATE Usuarios
         SET nombre = ?, apellido = ?, email = ?, telefono = ?, rol = ?
       WHERE id = ?'
    );
    $stmt->bind_param(
      'ssssii',
      $d['nombre'], $d['apellido'], $d['email'], $d['telefono'], $d['rol'], $id
    );
    $ok = $stmt->execute();
    if (!$ok) { $this->error = $stmt->error; }
    return $ok;
  }

  public function delete(int $id): bool {
    $stmt = $this->db->prepare('DELETE FROM Usuarios WHERE id=?');
    $stmt->bind_param('i', $id);
    $ok = $stmt->execute();
    if(!$ok){ $this->error = $stmt->error; }
    return $ok;
  }
public function voluntariosElegibles(): array {
  $sql = "SELECT u.id, u.nombre, u.apellido, u.email
          FROM Usuarios u
          JOIN Roles r ON r.id = u.rol
          LEFT JOIN Voluntarios v 
                 ON v.usuario = u.id AND v.estado = 'Activo'
          WHERE r.nombre = 'Voluntario'
            AND v.id IS NULL
          ORDER BY u.nombre, u.apellido";
  $res = $this->db->query($sql);
  return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}

}
