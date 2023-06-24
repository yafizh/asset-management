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
    id_jenis_aset BIGINT UNSIGNED,
    nama VARCHAR(255),
    PRIMARY KEY(id),
    FOREIGN KEY (id_jenis_aset) REFERENCES jenis_aset (id) ON DELETE CASCADE 
);

CREATE TABLE `manajemen_aset`.`pengguna`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    status TINYINT UNSIGNED COMMENT '1 = ADMIN, 2 = PETUGAS, 3 = PEGAWAI , 4 = KEPALA BALAI',
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
    id_kategori_aset BIGINT UNSIGNED,
    nama VARCHAR(255),
    jumlah INT UNSIGNED,
    PRIMARY KEY(id),
    FOREIGN KEY (id_kategori_aset) REFERENCES kategori_aset (id) ON DELETE CASCADE 
);

CREATE TABLE `manajemen_aset`.`aset_masuk` (
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_aset BIGINT UNSIGNED,
    tanggal DATE,
    jumlah INT UNSIGNED,
    keterangan TEXT,
    PRIMARY KEY(id),
    FOREIGN KEY (id_aset) REFERENCES aset (id) ON DELETE CASCADE
);

CREATE TABLE `manajemen_aset`.`aset_rusak` (
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_aset BIGINT UNSIGNED,
    tanggal DATE,
    jumlah INT UNSIGNED,
    keterangan TEXT,
    PRIMARY KEY(id),
    FOREIGN KEY (id_aset) REFERENCES aset (id) ON DELETE CASCADE
);

CREATE TABLE `manajemen_aset`.`aset_hilang` (
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_aset BIGINT UNSIGNED,
    tanggal DATE,
    jumlah INT UNSIGNED,
    keterangan TEXT,
    PRIMARY KEY(id),
    FOREIGN KEY (id_aset) REFERENCES aset (id) ON DELETE CASCADE
);

CREATE TABLE `manajemen_aset`.`pemeliharaan_aset` (
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_aset BIGINT UNSIGNED,
    tanggal_mulai DATE,
    tanggal_selesai DATE,
    jumlah INT UNSIGNED,
    keterangan TEXT,
    PRIMARY KEY(id),
    FOREIGN KEY (id_aset) REFERENCES aset (id) ON DELETE CASCADE
);

CREATE TABLE `manajemen_aset`.`peminjaman_aset`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_user_peminjam BIGINT UNSIGNED,
    id_user_verifikator BIGINT UNSIGNED,
    id_aset BIGINT UNSIGNED,
    alasan TEXT,
    tanggal_waktu_pengajuan TIMESTAMP NULL DEFAULT NULL,
    tanggal_waktu_verifikasi TIMESTAMP NULL DEFAULT NULL,
    keterangan_pengajuan TEXT,
    status TINYINT UNSIGNED, 
    PRIMARY KEY(id),
    FOREIGN KEY (id_user_peminjam) REFERENCES pegawai (id) ON DELETE CASCADE,
    FOREIGN KEY (id_user_verifikator) REFERENCES pegawai (id) ON DELETE CASCADE,
    FOREIGN KEY (id_aset) REFERENCES aset (id) ON DELETE CASCADE
);

CREATE TABLE `manajemen_aset`.`pengembalian_aset`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_peminjaman_aset BIGINT UNSIGNED,
    id_user_verifikator BIGINT UNSIGNED,
    id_aset BIGINT UNSIGNED,
    alasan TEXT,
    tanggal_waktu_pengajuan TIMESTAMP NULL DEFAULT NULL,
    tanggal_waktu_verifikasi TIMESTAMP NULL DEFAULT NULL,
    keterangan_pengajuan TEXT,
    status TINYINT UNSIGNED, 
    PRIMARY KEY(id),
    FOREIGN KEY (id_peminjaman_aset) REFERENCES peminjaman_aset (id) ON DELETE CASCADE,
    FOREIGN KEY (id_user_verifikator) REFERENCES pegawai (id) ON DELETE CASCADE,
    FOREIGN KEY (id_aset) REFERENCES aset (id) ON DELETE CASCADE
);