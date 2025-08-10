<?php
require_once __DIR__ . '/BaseModel.php';

class Adopcion extends BaseModel {
  public function crearSolicitud(array $d): bool {
    $stmt = $this->db->prepare('INSERT INTO Adopciones (fecha, usuario, mascota) VALUES (NOW(), ?, ?)');
    $stmt->bind_param('ii', $d['usuario'], $d['mascota']);
    $ok = $stmt->execute();
    if (!$ok) { $this->error = $stmt->error; return false; }

    $mensaje = "Nueva solicitud de adopción: usuario={$d['usuario']} mascota={$d['mascota']} motivo={$d['motivo']} experiencia={$d['experiencia']} contacto={$d['contacto']}
";
    @file_put_contents(__DIR__ . '/../../storage/adopciones.log', $mensaje, FILE_APPEND);

    return true;
  }
}