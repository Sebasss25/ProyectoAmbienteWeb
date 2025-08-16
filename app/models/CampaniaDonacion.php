<?php
require_once __DIR__ . '/BaseModel.php';

class CampaniaDonacion extends BaseModel
{
    public function registrarDonacion(int $campania_id, int $usuario_id, float $cantidad): bool
    {
        $stmt = $this->db->prepare('INSERT INTO DonacionesCampanias (fecha, cantidad, usuario, campania) VALUES (NOW(), ?, ?, ?)');
        $stmt->bind_param('dii', $cantidad, $usuario_id, $campania_id);

        try {
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function obtenerDonacionesUsuario(int $campania_id, int $usuario_id): array
    {
        $stmt = $this->db->prepare('SELECT * FROM DonacionesCampanias WHERE campania = ? AND usuario = ? ORDER BY fecha DESC');
        $stmt->bind_param('ii', $campania_id, $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function totalDonado(int $campania_id): float
    {
        $stmt = $this->db->prepare('SELECT SUM(cantidad) as total FROM DonacionesCampanias WHERE campania = ?');
        $stmt->bind_param('i', $campania_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return (float) ($result['total'] ?? 0);
    }

    public function obtenerTodasLasDonaciones(): array
    {
        $sql = 'SELECT dc.*, u.email as usuario_email, c.nombre as campania_nombre 
            FROM DonacionesCampanias dc
            JOIN Usuarios u ON dc.usuario = u.id
            JOIN Campanias c ON dc.campania = c.id
            ORDER BY dc.fecha DESC';
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function obtenerTotalDonadoGeneral(): float
    {
        $sql = 'SELECT SUM(cantidad) as total FROM DonacionesCampanias';
        $result = $this->db->query($sql)->fetch_assoc();
        return (float) ($result['total'] ?? 0);
    }
}