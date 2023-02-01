INSERT INTO `manajemen_aset`.`pengguna` (
    username,
    password,
    status
) VALUES 
('admin', 'admin', 'ADMIN'),
('petugas', 'petugas', 'PETUGAS'),
('198609262015051007', '198609262015051007', 'PEGAWAI'),
('198609262115051340', '198609262115051340', 'PEGAWAI'),
('198609262115051331', '198609262115051331', 'PEGAWAI'),
('198609262115051342', '198609262115051342', 'PEGAWAI'),
('198609262115051337', '198609262115051337', 'PEGAWAI'),
('198609262115051338', '198609262115051338', 'PEGAWAI'),
('198609262015051003', '198609262015051003', 'PEGAWAI');

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
(3, '198609262015051007', 'Muhammad Ali', '1998-05-18', 'Banjarbaru', 'Penyuluh Pertanian Pertama', '2018-01-01', '', 'SMA/SMK', '', 'uploads/gambar_pegawai/pegawai1.jpg'),
(4, '198609262115051340', 'Agus Setiati', '1998-05-18', 'Banjarbaru', 'Penata Muda', '2018-01-01', '', 'S1', '', 'uploads/gambar_pegawai/pegawai3.jpg'),
(5, '198609262115051331', 'Ahmad Isa Anshari, SE', '1998-05-18', 'Banjarbaru', 'Penata Muda', '2018-01-01', '', 'S1', '', 'uploads/gambar_pegawai/pegawai4.jpg'),
(6, '198609262115051342', 'Juhdy', '1998-05-18', 'Banjarbaru', 'Penata Muda', '2018-01-01', '', 'S1', '', 'uploads/gambar_pegawai/pegawai2.jpg'),
(7, '198609262115051337', 'Jumarni', '1998-05-18', 'Banjarbaru', 'Teknisi', '2018-01-01', '', 'S1', '', 'uploads/gambar_pegawai/pegawai5.jpg'),
(8, '198609262115051338', 'Kusyanti', '1998-05-18', 'Banjarbaru', 'Teknisi', '2018-01-01', '', 'S1', '', 'uploads/gambar_pegawai/pegawai6.jpg'),
(9, '198609262015051003', 'Muhammad Syarif, S.ST', '1998-05-18', 'Banjarbaru', 'Teknisi', '2018-01-01', '', 'S1', '', 'uploads/gambar_pegawai/pegawai7.jpg');