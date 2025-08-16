DROP DATABASE DejandoHuellaDB;

CREATE DATABASE IF NOT EXISTS DejandoHuellaDB
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE DejandoHuellaDB;

CREATE USER IF NOT EXISTS 'patitas'@'localhost' IDENTIFIED BY 'patitas123';
-- Permisos solo sobre tu DB
GRANT ALL PRIVILEGES ON DejandoHuellaDB.* TO 'patitas'@'localhost';
FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS Roles (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre ENUM('Administrador','Usuario','Voluntario') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS Usuarios (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  apellido VARCHAR(100) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  telefono VARCHAR(20) NOT NULL,
  rol INT NOT NULL,
  CONSTRAINT fk_usuarios_roles FOREIGN KEY (rol)
    REFERENCES Roles(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS Mascotas (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  raza VARCHAR(100) NOT NULL,
  edad INT NOT NULL,
  descripcion TEXT NOT NULL,
  foto VARCHAR(255),
  estado ENUM('Disponible','Adoptado') NOT NULL DEFAULT 'Disponible',
  usuario INT NOT NULL,
  CONSTRAINT fk_mascotas_usuarios FOREIGN KEY (usuario)
    REFERENCES Usuarios(id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS HistorialMedico (
  id INT PRIMARY KEY AUTO_INCREMENT,
  mascota INT NOT NULL,
  fecha DATETIME NOT NULL,
  diagnostico TEXT NOT NULL,
  tratamiento TEXT NOT NULL,
  veterinario VARCHAR(100) NOT NULL,
  observaciones TEXT,
  estado ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  CONSTRAINT fk_hist_mascota FOREIGN KEY (mascota)
    REFERENCES Mascotas(id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS Adopciones (
  id INT PRIMARY KEY AUTO_INCREMENT,
  fecha DATETIME NOT NULL,
  usuario INT NOT NULL,
  mascota INT NOT NULL,
  CONSTRAINT fk_adopciones_usuario FOREIGN KEY (usuario)
    REFERENCES Usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_adopciones_mascota FOREIGN KEY (mascota)
    REFERENCES Mascotas(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  INDEX idx_adopciones_fecha (fecha)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS Reportes (
  id INT PRIMARY KEY AUTO_INCREMENT,
  fecha DATETIME NOT NULL,
  usuario INT NOT NULL,
  mascota INT NULL,
  provincia VARCHAR(100) NOT NULL,
  canton VARCHAR(100) NOT NULL,
  distrito VARCHAR(100) NOT NULL,
  detalles TEXT NOT NULL,
  CONSTRAINT fk_reportes_usuario FOREIGN KEY (usuario)
    REFERENCES Usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_reportes_mascota FOREIGN KEY (mascota)
    REFERENCES Mascotas(id) ON UPDATE CASCADE ON DELETE SET NULL,
  INDEX idx_reportes_fecha (fecha)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS Campanias (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  descripcion TEXT NOT NULL,
  fechaInicio DATETIME NOT NULL,
  fechaFin DATETIME NOT NULL,
  objetivo DECIMAL(10,2) NOT NULL,
  estado ENUM('Activa','Inactiva') NOT NULL DEFAULT 'Activa',
  usuario INT NOT NULL,
  CONSTRAINT fk_campanias_usuario FOREIGN KEY (usuario)
    REFERENCES Usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  INDEX idx_campanias_estado (estado),
  INDEX idx_campanias_fechas (fechaInicio, fechaFin)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS DonacionesCampanias (
  id INT PRIMARY KEY AUTO_INCREMENT,
  fecha DATETIME NOT NULL,
  cantidad DECIMAL(10,2) NOT NULL,
  usuario INT NOT NULL,
  campania INT NOT NULL,
  CONSTRAINT fk_donaciones_usuario FOREIGN KEY (usuario)
    REFERENCES Usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_donaciones_campania FOREIGN KEY (campania)
    REFERENCES Campanias(id) ON UPDATE CASCADE ON DELETE CASCADE,
  INDEX idx_donaciones_fecha (fecha)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS Inventario (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  tipo VARCHAR(100) NOT NULL,
  cantidad INT NOT NULL,
  fechaIngreso DATETIME NOT NULL,
  fechaCaducidad DATETIME NULL,
  proveedor VARCHAR(100) NOT NULL,
  fuente ENUM('Compra','Donación') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS Eventos (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  descripcion TEXT NOT NULL,
  fecha DATETIME NOT NULL,
  ubicacion VARCHAR(255) NOT NULL,
  responsable INT NOT NULL,
  tipo ENUM('Presencial','Virtual') NOT NULL,
  estado ENUM('En curso','Planificado','Finalizado') NOT NULL DEFAULT 'Planificado',
  CONSTRAINT fk_eventos_responsable FOREIGN KEY (responsable)
    REFERENCES Usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  INDEX idx_eventos_fecha (fecha)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS EventosAsistencia (
  id INT PRIMARY KEY AUTO_INCREMENT,
  evento INT NOT NULL,
  usuario INT NOT NULL,
  CONSTRAINT fk_asistencia_evento FOREIGN KEY (evento)
    REFERENCES Eventos(id) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_asistencia_usuario FOREIGN KEY (usuario)
    REFERENCES Usuarios(id) ON UPDATE CASCADE ON DELETE CASCADE,
  UNIQUE KEY uq_evento_usuario (evento, usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS Voluntarios (
  id INT PRIMARY KEY AUTO_INCREMENT,
  usuario INT NOT NULL,
  fechaInicio DATETIME NOT NULL,
  fechaFin DATETIME NULL,
  horas INT NOT NULL DEFAULT 0,
  estado ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  CONSTRAINT fk_voluntarios_usuario FOREIGN KEY (usuario)
    REFERENCES Usuarios(id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS ActividadesVoluntarios (
  id INT PRIMARY KEY AUTO_INCREMENT,
  voluntario INT NOT NULL,
  actividad VARCHAR(255) NOT NULL,
  CONSTRAINT fk_actividades_voluntario FOREIGN KEY (voluntario)
    REFERENCES Voluntarios(id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SELECT * FROM Roles;
SELECT * FROM Mascotas;
SELECT * FROM Usuarios;
INSERT INTO Roles (nombre) VALUES ('Administrador'),('Usuario'),('Voluntario')
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);


-- Contraseñas (bcrypt):
-- admin@gmail.com     -> admin123
-- usuario@gmail.com   -> usuario123
-- voluntario@gmail.com-> voluntario123
INSERT INTO Usuarios (nombre, apellido, email, password, telefono, rol) VALUES
('Justin','Admin','admin@gmail.com',
 '$2b$10$xB5XOJoFb8Wkdj4.zFySYuIfC7SzpxQT7WApDiXDS9ao.bZdhxK2W',
 '8888-0001', 1),
('Justin','Usuario','usuario@gmail.com',
 '$2b$10$BHWknxZsMbeqrV9P8gV.7eX4EiZEu4KgvPER8RbA0NEbC6s87bywO',
 '8888-0002', 2),
('Justin','Voluntario','voluntario@gmail.com',
 '$2b$10$jULFt6czxlx0pxlKb13VBufMYScFQqgf7lUd3aAWlX6/3fS.dNXPa',
 '8888-0003', 3);
