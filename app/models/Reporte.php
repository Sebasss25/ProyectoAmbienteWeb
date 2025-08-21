<?php
require_once __DIR__ . '/BaseModel.php';

class Reporte extends BaseModel
{
    public function all(): array
    {
        $sql = "SELECT r.*,
                       CONCAT(u.nombre, ' ', u.apellido) AS usuario_nombre,
                       u.email AS usuario_email
                FROM Reportes r
                LEFT JOIN Usuarios u ON u.id = r.usuario
                ORDER BY r.fecha DESC, r.id DESC";
        $res = $this->db->query($sql);
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function create(array $data): bool
    {
        $usuario = $data['usuario'] ?? null; 
        $mascota = null;                      

        $stmt = $this->db->prepare("
            INSERT INTO Reportes (fecha, usuario, mascota, provincia, canton, distrito, detalles)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "siissss",
            $data['fecha'],
            $usuario,
            $mascota,
            $data['provincia'],
            $data['canton'],
            $data['distrito'],
            $data['detalles']
        );

        $ok = $stmt->execute();
        if (!$ok) { $this->error = $stmt->error; }
        return $ok;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM Reportes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row ?: null;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM Reportes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $ok = $stmt->execute();
        if (!$ok) { $this->error = $stmt->error; }
        return $ok;
    }

    public function getError(): ?string {
        return $this->error ?? null;
    }
}
