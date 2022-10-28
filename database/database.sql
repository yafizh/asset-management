DROP DATABASE IF EXISTS manajemen_aset;
CREATE DATABASE manajemen_aset;
USE manajemen_aset;

CREATE TABLE jenis_aset(
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255),
    keterangan TEXT
);

CREATE TABLE sifat_aset(
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255),
    keterangan TEXT
);

CREATE TABLE pengguna(
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    status VARCHAR(255)
);

CREATE TABLE pegawai(
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    id_pengguna BIGINT UNSIGNED REFERENCES pengguna(id),
    nip VARCHAR(255) UNIQUE,
    nama VARCHAR(255),
    tanggal_lahir DATE,
    tempat_lahir VARCHAR(255),
    jabatan VARCHAR(255),
    tmt DATE,
    sk_tmt VARCHAR(255),
    pendidikan_terakhir VARCHAR(20),
    ijazah_pendidikan_terakhir VARCHAR(255),
    foto VARCHAR(255)
);

CREATE TABLE aset(
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    id_jenis_aset BIGINT UNSIGNED REFERENCES jenis_aset(id),
    id_sifat_aset BIGINT UNSIGNED REFERENCES sifat_aset(id),
    nama VARCHAR(255),
    tanggal_masuk DATE,
    detail JSON,
    foto VARCHAR(255),
    keterangan TEXT
);

CREATE TABLE aset_rusak(
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    id_aset BIGINT UNSIGNED REFERENCES aset(id),
    tanggal DATE,
    keterangan TEXT
);

CREATE TABLE aset_hilang(
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    id_aset BIGINT UNSIGNED REFERENCES aset(id),
    tanggal DATE,
    keterangan TEXT
);

CREATE TABLE pemeliharaan_aset(
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    id_aset BIGINT UNSIGNED REFERENCES aset(id),
    tanggal_mulai DATE,
    tanggal_selesai DATE,
    keterangan TEXT
);

CREATE TABLE peminjaman_aset(
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    id_pegawai BIGINT UNSIGNED REFERENCES pegawai(id),
    id_aset BIGINT UNSIGNED REFERENCES aset(id),
    alasan_peminjaman VARCHAR(255),
    timestamp_pengajuan TIMESTAMP NULL DEFAULT NULL,
    timestamp_pengajuan_ditentukan TIMESTAMP NULL DEFAULT NULL,
    keterangan_pengajuan TEXT,
    alasan_pengembalian VARCHAR(255),
    timestamp_pengembalian TIMESTAMP NULL DEFAULT NULL,
    timestamp_pengembalian_ditentukan TIMESTAMP NULL DEFAULT NULL,
    keterangan_pengembalian TEXT,
    status TINYINT UNSIGNED NULL DEFAULT NULL COMMENT '1 = MENGAJUKAN PEMINJAMAN, 2 = PENGAJUAN DITOLAK, 3 = PENGAJUAN DITERIMA, 4 = MENGAJUKAN PENGEMBALIAN, 5 = PENGEMBALIAN DITOLAK, 6 = PENGAMBALIAN DITERIMA'
);