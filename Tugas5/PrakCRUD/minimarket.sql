-- SQL Dump for Database: minimarket

CREATE DATABASE IF NOT EXISTS minimarket;
USE minimarket;

-- =======================
-- TABEL: lokasi
-- =======================
CREATE TABLE lokasi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  alamat VARCHAR(255) NOT NULL,
  kota VARCHAR(100) NOT NULL,
  provinsi VARCHAR(100) NOT NULL
);

-- =======================
-- TABEL: kontak
-- =======================
CREATE TABLE kontak (
  id INT AUTO_INCREMENT PRIMARY KEY,
  no_hp VARCHAR(20) NOT NULL,
  email VARCHAR(100) NOT NULL
);

-- =======================
-- TABEL: owner
-- =======================
CREATE TABLE owner (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_owner VARCHAR(100) NOT NULL,
  nik VARCHAR(30) NOT NULL
);

-- =======================
-- TABEL: jarak
-- =======================
CREATE TABLE jarak (
  id INT AUTO_INCREMENT PRIMARY KEY,
  jarak_km DECIMAL(5,2) NOT NULL,
  deskripsi VARCHAR(255) DEFAULT NULL
);

-- =======================
-- TABEL: minimarket
-- =======================
CREATE TABLE minimarket (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_minimarket VARCHAR(100) NOT NULL,
  id_lokasi INT NOT NULL,
  id_kontak INT NOT NULL,
  id_owner INT NOT NULL,
  id_jarak INT NOT NULL,
  FOREIGN KEY (id_lokasi) REFERENCES lokasi(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_kontak) REFERENCES kontak(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_owner) REFERENCES owner(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_jarak) REFERENCES jarak(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- =======================
-- SAMPLE DATA
-- =======================
INSERT INTO lokasi (alamat, kota, provinsi) VALUES
('Jl. Merdeka No. 10', 'Bandung', 'Jawa Barat'),
('Jl. Sudirman No. 15', 'Jakarta', 'DKI Jakarta');

INSERT INTO kontak (no_hp, email) VALUES
('081234567890', 'alfamart@gmail.com'),
('081298765432', 'indomaret@gmail.com');

INSERT INTO owner (nama_owner, nik) VALUES
('Budi Santoso', '3201110401990001'),
('Siti Aminah', '3201220502870002');

INSERT INTO jarak (jarak_km, deskripsi) VALUES
(1.5, 'Dekat pusat kota'),
(3.2, 'Pinggir kota');

INSERT INTO minimarket (nama_minimarket, id_lokasi, id_kontak, id_owner, id_jarak) VALUES
('Alfamart', 1, 1, 1, 1),
('Indomaret', 2, 2, 2, 2);
