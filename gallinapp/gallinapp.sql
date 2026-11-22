-- =========================================================
-- GallinApp - UNA sola base de datos (tablas + datos de ejemplo)
-- Sirve en XAMPP y en el hosting: en phpMyAdmin entra a tu base y usa Importar.
-- Si las tablas ya existen, se borran y se crean de nuevo.
-- =========================================================
SET NAMES utf8mb4;
DROP TABLE IF EXISTS ventas, registros, lotes, tipos, galpones, usuarios;

-- 1. Usuarios que pueden entrar al sistema, con su rol
CREATE TABLE usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  nombre     VARCHAR(100) NOT NULL,
  correo     VARCHAR(100) NOT NULL UNIQUE,
  clave      VARCHAR(255) NOT NULL,
  rol        ENUM('administrador', 'usuario') NOT NULL DEFAULT 'usuario'
);

-- 2. Galpones: dónde viven las aves y cuántas caben
CREATE TABLE galpones (
  id_galpon INT AUTO_INCREMENT PRIMARY KEY,
  nombre    VARCHAR(50) NOT NULL,
  capacidad INT NOT NULL
);

-- 3. Los 5 tipos de aves
CREATE TABLE tipos (
  id_tipo INT AUTO_INCREMENT PRIMARY KEY,
  nombre  VARCHAR(50) NOT NULL
);

-- 4. Lotes: qué tipo de ave ingresó, a qué galpón y cuántas
CREATE TABLE lotes (
  id_lote       INT AUTO_INCREMENT PRIMARY KEY,
  id_galpon     INT NOT NULL,
  id_tipo       INT NOT NULL,
  fecha_ingreso DATE NOT NULL,
  cantidad      INT NOT NULL,
  FOREIGN KEY (id_galpon) REFERENCES galpones(id_galpon) ON DELETE CASCADE,
  FOREIGN KEY (id_tipo)   REFERENCES tipos(id_tipo)
);

-- 5. Registro diario: aves muertas, alimento y agua de cada lote
CREATE TABLE registros (
  id_registro INT AUTO_INCREMENT PRIMARY KEY,
  id_lote     INT NOT NULL,
  fecha       DATE NOT NULL,
  muertas     INT NOT NULL DEFAULT 0,
  alimento_kg DECIMAL(8,2) NOT NULL DEFAULT 0,
  agua_litros DECIMAL(8,2) NOT NULL DEFAULT 0,
  FOREIGN KEY (id_lote) REFERENCES lotes(id_lote) ON DELETE CASCADE
);

-- 6. Ventas: aves vendidas de cada lote
CREATE TABLE ventas (
  id_venta  INT AUTO_INCREMENT PRIMARY KEY,
  id_lote   INT NOT NULL,
  fecha     DATE NOT NULL,
  cantidad  INT NOT NULL,
  precio    DECIMAL(8,2) NOT NULL,   -- precio por ave (Bs)
  comprador VARCHAR(100),
  FOREIGN KEY (id_lote) REFERENCES lotes(id_lote) ON DELETE CASCADE
);

-- ---------- Datos iniciales ----------

-- Administrador: admin@gallinapp.com        Contraseña: admin123
-- Usuario:       trabajador@gallinapp.com   Contraseña: trabajador123
INSERT INTO usuarios (nombre, correo, clave, rol) VALUES
('Administrador', 'admin@gallinapp.com', '$2y$10$7Y238jewgy1pBdEyTdmy3eqbTNIR1adYvYotfN3yhgTQH2xb0ARI6', 'administrador'),
('Trabajador',    'trabajador@gallinapp.com', '$2y$10$RkrNcJ6AEz1ggh5nch1uw.94ijn26tIcFKDRT3hSNLK5k43Aalyje', 'usuario');

INSERT INTO tipos (nombre) VALUES
('Pollo de engorde'), ('Gallina ponedora'), ('Gallo'), ('Gallina criolla'), ('Reproductora');

-- ---------- Datos de ejemplo (se pueden borrar desde el sistema) ----------
-- Usan la fecha de hoy (CURDATE) para que las alertas del panel se vean al importar.
INSERT INTO galpones (nombre, capacidad) VALUES
('Galpón 1', 600), ('Galpón 2', 400), ('Galpón 3', 200);

INSERT INTO lotes (id_galpon, id_tipo, fecha_ingreso, cantidad) VALUES
(1, 1, CURDATE() - INTERVAL 30 DAY, 500),
(2, 2, CURDATE() - INTERVAL 25 DAY, 300),
(3, 4, CURDATE() - INTERVAL 18 DAY, 150);

INSERT INTO registros (id_lote, fecha, muertas, alimento_kg, agua_litros) VALUES
(1, CURDATE() - INTERVAL 1 DAY, 3, 60.50, 120),
(1, CURDATE(),                  2, 62.00, 125),
(2, CURDATE() - INTERVAL 1 DAY, 1, 30.00, 65),
(3, CURDATE() - INTERVAL 1 DAY, 5, 12.00, 28),
(3, CURDATE(),                  4, 12.50, 30);

INSERT INTO ventas (id_lote, fecha, cantidad, precio, comprador) VALUES
(1, CURDATE() - INTERVAL 2 DAY, 100, 35.00, 'Mercado La Cancha');
