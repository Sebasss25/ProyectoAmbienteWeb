<?php
require_once __DIR__ . '/BaseModel.php';

class EventoAsistencia extends BaseModel {
    public function registrarAsistencia(int $evento_id, int $usuario_id): bool {
        $stmt = $this->db->prepare('INSERT INTO EventosAsistencia (evento, usuario) VALUES (?, ?)');
        $stmt->bind_param('ii', $evento_id, $usuario_id);
        
        try {
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            $this->error = $e->getCode() === 1062 ? 'Ya estás registrado en este evento' : $e->getMessage();
            return false;
        }
    }

    public function verificarAsistencia(int $evento_id, int $usuario_id): bool {
        $stmt = $this->db->prepare('SELECT id FROM EventosAsistencia WHERE evento = ? AND usuario = ?');
        $stmt->bind_param('ii', $evento_id, $usuario_id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
}