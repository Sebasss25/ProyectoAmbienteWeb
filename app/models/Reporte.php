<?php
require_once __DIR__ . '/BaseModel.php';

class Reporte extends BaseModel
{
    public function all()
    {
        $stmt = $this->db->prepare("SELECT * FROM Reportes ORDER BY fecha DESC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO Reportes (fecha, usuario, mascota, provincia, canton, distrito, detalles)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "siissss",
            $data['fecha'],
            $data['usuario'],
            $data['mascota'],
            $data['provincia'],
            $data['canton'],
            $data['distrito'],
            $data['detalles']
        );

        return $stmt->execute();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Reportes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM Reportes WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
