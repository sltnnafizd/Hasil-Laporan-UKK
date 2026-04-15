-- ============================================================
-- DATABASE: Aplikasi Pengaduan Sarana Sekolah
-- ============================================================

CREATE DATABASE IF NOT EXISTS `pengaduan_sarana`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `pengaduan_sarana`;

-- ------------------------------------------------------------
-- Tabel: admin
-- ------------------------------------------------------------
CREATE TABLE `admin` (
  `id_admin`  INT(11)      NOT NULL AUTO_INCREMENT,
  `username`  VARCHAR(100) NOT NULL,
  `password`  VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `uq_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data default admin
INSERT INTO `admin` (`username`, `password`) VALUES ('admin', '123');

-- ------------------------------------------------------------
-- Tabel: kategori
-- ------------------------------------------------------------
CREATE TABLE `kategori` (
  `id_kategori`   INT(11)      NOT NULL AUTO_INCREMENT,
  `ket_kategori`  VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id_kategori`),
  UNIQUE KEY `uq_ket_kategori` (`ket_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data kategori awal
INSERT INTO `kategori` (`ket_kategori`) VALUES
  ('Kursi / Meja'),
  ('Papan Tulis'),
  ('Proyektor / LCD'),
  ('Komputer / Laptop'),
  ('Kipas Angin / AC'),
  ('Lampu / Listrik'),
  ('Pintu / Jendela'),
  ('Kran / Pipa Air'),
  ('Alat Olahraga'),
  ('Lainnya');

-- ------------------------------------------------------------
-- Tabel: input_aspirasi
-- ------------------------------------------------------------
CREATE TABLE `input_aspirasi` (
  `id_pelaporan` INT(11)      NOT NULL AUTO_INCREMENT,
  `nis`          VARCHAR(20)  NOT NULL,
  `id_kategori`  INT(11)      NOT NULL,
  `lokasi`       VARCHAR(255) NOT NULL,
  `ket`          TEXT         NOT NULL,
  `created_at`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal`      DATE         GENERATED ALWAYS AS (DATE(`created_at`)) STORED,
  PRIMARY KEY (`id_pelaporan`),
  KEY `fk_aspirasi_kategori` (`id_kategori`),
  CONSTRAINT `fk_aspirasi_kategori`
    FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Tabel: aspirasi  (status & feedback dari admin)
-- ------------------------------------------------------------
CREATE TABLE `aspirasi` (
  `id`           INT(11)      NOT NULL AUTO_INCREMENT,
  `id_pelaporan` INT(11)      NOT NULL,
  `id_kategori`  INT(11)      NOT NULL,
  `status`       ENUM('Menunggu','Proses','Selesai') NOT NULL DEFAULT 'Menunggu',
  `feedback`     TEXT         DEFAULT NULL,
  `updated_at`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_id_pelaporan` (`id_pelaporan`),
  CONSTRAINT `fk_status_pelaporan`
    FOREIGN KEY (`id_pelaporan`) REFERENCES `input_aspirasi` (`id_pelaporan`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_aspirasi_kat`
    FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`)
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Tabel: histori  (riwayat perubahan status pengaduan)
-- ------------------------------------------------------------
CREATE TABLE `histori` (
  `id_histori`   INT(11)      NOT NULL AUTO_INCREMENT,
  `id_pelaporan` INT(11)      NOT NULL,
  `status_lama`  VARCHAR(50)  DEFAULT NULL,
  `status_baru`  VARCHAR(50)  NOT NULL,
  `feedback`     TEXT         DEFAULT NULL,
  `diubah_oleh`  VARCHAR(100) DEFAULT NULL,
  `waktu`        TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_histori`),
  KEY `fk_histori_pelaporan` (`id_pelaporan`),
  CONSTRAINT `fk_histori_pelaporan`
    FOREIGN KEY (`id_pelaporan`) REFERENCES `input_aspirasi` (`id_pelaporan`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
