INSERT INTO `manajemen_aset`.`pengguna` (
    username,
    password,
    status
) VALUES 
('admin', 'admin', 'ADMIN'),
('petugas', 'petugas', 'PETUGAS'),
('18630320', '18630320', 'PEGAWAI');

INSERT INTO `manajemen_aset`.`jenis_aset` (
    nama
) VALUES 
('Aset Tetap'),
('Aset Bergerak');

INSERT INTO `manajemen_aset`.`kategori_aset` (
    nama
) VALUES 
('Kamera'),
('Kursi'),
('Meja'),
('Motor'),
('Mobil');

INSERT INTO `manajemen_aset`.`aset`(
    id,
    id_jenis_aset,
    id_kategori_aset,
    nama,
    tanggal_masuk,
    foto,
    status
) VALUES 
(1, 1, 2, 'Kamera 1', CURRENT_DATE(), 'uploads/gambar_aset/kamera1.webp'),
(2, 1, 2, 'Kamera 2', CURRENT_DATE(), 'uploads/gambar_aset/kamera2.webp'),
(3, 1, 2, 'Kamera 3', CURRENT_DATE(), 'uploads/gambar_aset/kamera3.webp'),
(4, 4, 2, 'Motor 1', CURRENT_DATE(), 'uploads/gambar_aset/motor1.webp'),
(5, 4, 2, 'Motor 2', CURRENT_DATE(), 'uploads/gambar_aset/motor2.webp'),
(6, 4, 2, 'Motor 3', CURRENT_DATE(), 'uploads/gambar_aset/motor3.webp'),
(7, 5, 2, 'Mobil 1', CURRENT_DATE(), 'uploads/gambar_aset/mobil1.webp'),
(8, 5, 2, 'Mobil 2', CURRENT_DATE(), 'uploads/gambar_aset/mobil2.webp'),
(9, 5, 2, 'Mobil 3', CURRENT_DATE(), 'uploads/gambar_aset/mobil3.webp');

INSERT INTO `manajemen_aset`.`detail_aset` (
    id_aset,
    kolom,
    nilai 
) VALUES 
(1, "Merk", "Sony"),
(1, "Warna", "Hitam"),
(1, "Lensa", "Canon 50mm"),
(2, "Merk", "Fujifilm"),
(2, "Warna", "Silver"),
(3, "Lensa", "Fujinon 35mm"),
(3, "Merk", "Fujifilm"),
(3, "Lensa", "Fujinon 23mm"),
(4, "Merk", "Suzuki"),
(4, "Warna", "Putih Cokelat"),
(4, "Plat", "DA 12345 DA"),
(4, "Roda", "Roda 2"),
(5, "Merk", "Honda"),
(5, "Warna", "Hitam"),
(5, "Roda", "Roda 2"),
(6, "Merk", "Honda"),
(6, "Warna", "Merah"),
(6, "Roda", "Roda 2"),
(7, "Warna", "Kuning"),
(7, "Roda", "Roda 4"),
(8, "Warna", "Biru"),
(8, "Roda", "Roda 4"),
(9, "Warna", "Putih"),
(9, "Merk", "Ford"),
(9, "Plat", "8CPP419"),
(9, "Roda", "Roda 4");

INSERT INTO `manajemen_aset`.`pegawai` (
    id_pengguna,
    nip,
    nama,
    tanggal_lahir,
    tempat_lahir,
    jabatan,
    tmt,
    sk_tmt,
    pendidikan_terakhir,
    ijazah_pendidikan_terakhir,
    foto
) VALUES 
(3, '18630220', 'Diki Suti Prasetya', '1998-05-18', 'Banjarbaru', 'Mahasiswa', '2018-01-01', '', 'SMA/SMK', '', '');