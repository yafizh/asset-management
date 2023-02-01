DROP DATABASE IF EXISTS `manajemen_aset`;
CREATE DATABASE `manajemen_aset`;
USE `manajemen_aset`;

CREATE TABLE `manajemen_aset`.`jenis_aset`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    nama VARCHAR(255),
    PRIMARY KEY(id)
);

CREATE TABLE `manajemen_aset`.`kategori_aset`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    nama VARCHAR(255),
    PRIMARY KEY(id)
);

CREATE TABLE `manajemen_aset`.`pengguna`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    status ENUM('ADMIN', 'PETUGAS', 'PEGAWAI', 'PIMPINAN'),
    PRIMARY KEY(id)
);

CREATE TABLE `manajemen_aset`.`pegawai`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_pengguna BIGINT UNSIGNED,
    nip VARCHAR(255) UNIQUE,
    nama VARCHAR(255),
    tanggal_lahir DATE,
    tempat_lahir VARCHAR(255),
    jabatan VARCHAR(255),
    tmt DATE,
    sk_tmt VARCHAR(255),
    pendidikan_terakhir VARCHAR(20),
    ijazah_pendidikan_terakhir VARCHAR(255),
    foto VARCHAR(255),
    PRIMARY KEY(id),
    FOREIGN KEY (id_pengguna) REFERENCES pengguna (id) ON DELETE CASCADE 
);

CREATE TABLE `manajemen_aset`.`aset`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_jenis_aset BIGINT UNSIGNED,
    id_kategori_aset BIGINT UNSIGNED,
    nama VARCHAR(255),
    tanggal_masuk DATE,
    foto VARCHAR(255),
    status TINYINT UNSIGNED NULL DEFAULT NULL COMMENT '1 = TERSEDIA, 2 = RUSAK, 3 = HILANG, 4 = DALAM MASA PEMELIHARAAN, 5 = SEDANG PENGAJUAN PEMINJAMAN, 6 = SEDANG DIPINJAM',
    PRIMARY KEY(id),
    FOREIGN KEY (id_jenis_aset) REFERENCES jenis_aset (id) ON DELETE CASCADE, 
    FOREIGN KEY (id_kategori_aset) REFERENCES kategori_aset (id) ON DELETE CASCADE 
);

CREATE TABLE `manajemen_aset`.`detail_aset` (
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_aset BIGINT UNSIGNED,
    kolom VARCHAR(255),
    nilai VARCHAR(255),
    PRIMARY KEY(id),
    FOREIGN KEY (id_aset) REFERENCES aset (id) ON DELETE CASCADE 
);

CREATE TABLE `manajemen_aset`.`aset_rusak` (
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_aset BIGINT UNSIGNED,
    tanggal DATE,
    keterangan TEXT,
    PRIMARY KEY(id),
    FOREIGN KEY (id_aset) REFERENCES aset (id) ON DELETE CASCADE
);

CREATE TABLE `manajemen_aset`.`aset_hilang` (
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_aset BIGINT UNSIGNED,
    tanggal DATE,
    keterangan TEXT,
    PRIMARY KEY(id),
    FOREIGN KEY (id_aset) REFERENCES aset (id) ON DELETE CASCADE
);

CREATE TABLE `manajemen_aset`.`pemeliharaan_aset` (
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_aset BIGINT UNSIGNED,
    tanggal_mulai DATE,
    tanggal_selesai DATE,
    keterangan TEXT,
    PRIMARY KEY(id),
    FOREIGN KEY (id_aset) REFERENCES aset (id) ON DELETE CASCADE
);

CREATE TABLE `manajemen_aset`.`peminjaman_aset`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_pegawai BIGINT UNSIGNED,
    id_aset BIGINT UNSIGNED,
    alasan_peminjaman VARCHAR(255),
    timestamp_pengajuan TIMESTAMP NULL DEFAULT NULL,
    timestamp_pengajuan_ditentukan TIMESTAMP NULL DEFAULT NULL,
    keterangan_pengajuan TEXT,
    alasan_pengembalian VARCHAR(255),
    timestamp_pengembalian TIMESTAMP NULL DEFAULT NULL,
    timestamp_pengembalian_ditentukan TIMESTAMP NULL DEFAULT NULL,
    keterangan_pengembalian TEXT,
    status TINYINT UNSIGNED NULL DEFAULT NULL COMMENT '1 = MENGAJUKAN PEMINJAMAN, 2 = PENGAJUAN DITOLAK, 3 = PENGAJUAN DITERIMA, 4 = MENGAJUKAN PENGEMBALIAN, 5 = PENGEMBALIAN DITOLAK, 6 = PENGAMBALIAN DITERIMA',
    PRIMARY KEY(id),
    FOREIGN KEY (id_pegawai) REFERENCES pegawai (id) ON DELETE CASCADE,
    FOREIGN KEY (id_aset) REFERENCES aset (id) ON DELETE CASCADE
);