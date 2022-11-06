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

CREATE VIEW view_jumlah_aset_tersedia AS SELECT 
    ja.id, 
    ja.nama, 
    (SELECT 
        COUNT(a.id) 
    FROM 
        aset AS a 
    WHERE 
        a.id_jenis_aset=ja.id 
        AND 
        IF(
            (
                (SELECT pa.status FROM peminjaman_aset AS pa WHERE pa.id_aset=a.id ORDER BY pa.id DESC LIMIT 1) = 2
                OR 
                (SELECT pa.status FROM peminjaman_aset AS pa WHERE pa.id_aset=a.id ORDER BY pa.id DESC LIMIT 1) = 6
                OR 
                (SELECT pa.status FROM peminjaman_aset AS pa WHERE pa.id_aset=a.id ORDER BY pa.id DESC LIMIT 1) IS NULL
            ),
            TRUE, 
            FALSE
        ) 
        AND 
        a.id NOT IN (
            SELECT 
                id_aset 
            FROM 
                aset_rusak 
            UNION ALL 
            SELECT 
                id_aset 
            FROM 
                aset_hilang 
            UNION ALL 
            SELECT 
                id_aset 
            FROM 
                pemeliharaan_aset 
            WHERE 
                tanggal_selesai IS NULL
            )
    ) AS tersedia 
FROM 
    jenis_aset AS ja

CREATE VIEW view_jumlah_aset_dipinjam AS SELECT 
    ja.id, 
    ja.nama, 
    (SELECT 
        COUNT(a.id) 
    FROM 
        aset AS a 
    WHERE 
        a.id_jenis_aset=ja.id 
        AND 
        IF(
            (SELECT pa.status FROM peminjaman_aset AS pa WHERE pa.id_aset=a.id ORDER BY pa.id DESC LIMIT 1) IN (3,4,5),
            TRUE, 
            FALSE
        ) 
    ) AS dipinjam 
FROM 
    jenis_aset AS ja