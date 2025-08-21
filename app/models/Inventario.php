<?php
require_once __DIR__ . '/BaseModel.php';

class Inventario extends BaseModel {
    public function all(): array {
        $sql = 'SELECT * FROM Inventario ORDER BY fechaIngreso DESC;';
        $res = $this->db->query($sql);
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function create(array $data)
    {
        $stmt = $this->db->prepare("INSERT INTO Inventario 
            (nombre, tipo, cantidad, fechaIngreso, fechaCaducidad, proveedor, fuente) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "ssissss",
            $data['nombre'],
            $data['tipo'],
            $data['cantidad'],
            $data['fechaIngreso'],
            $data['fechaCaducidad'],
            $data['proveedor'],
            $data['fuente']
        );
        return $stmt->execute();
    }



    public function search(string $nombre): array {
        $stmt = $this->db->prepare(
            'SELECT * FROM Inventario WHERE nombre LIKE ? ORDER BY fechaIngreso DESC'
        );
        $like = "%$nombre%";
        $stmt->bind_param('s', $like);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM Inventario WHERE id=?');
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        if (!$ok) { $this->error = $stmt->error; }
        return $ok;
    }
}
