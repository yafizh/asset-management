INSERT INTO `manajemen_aset`.`pengguna` (
    username,
    password,
    status
) VALUES 
('admin', 'admin', 1),
('198609262015051007', '198609262015051007', 1),
('198609262115051340', '198609262115051340', 2),
('198609262115051331', '198609262115051331', 3),
('198609262115051342', '198609262115051342', 4),
('198609262115051337', '198609262115051337', 3),
('198609262115051338', '198609262115051338', 3),
('198609262015051003', '198609262015051003', 3);

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
(2, '198609262015051007', 'Muhammad Ali', '1998-05-18', 'Banjarbaru', 'Penyuluh Pertanian Pertama', '2018-01-01', '', 'SMA/SMK', '', 'uploads/gambar_pegawai/pegawai1.jpg'),
(3, '198609262115051340', 'Agus Setiati', '1998-05-18', 'Banjarbaru', 'Penata Muda', '2018-01-01', '', 'S1', '', 'uploads/gambar_pegawai/pegawai3.jpg'),
(4, '198609262115051331', 'Ahmad Isa Anshari, SE', '1998-05-18', 'Banjarbaru', 'Penata Muda', '2018-01-01', '', 'S1', '', 'uploads/gambar_pegawai/pegawai4.jpg'),
(5, '198609262115051342', 'Juhdy', '1998-05-18', 'Banjarbaru', 'Penata Muda', '2018-01-01', '', 'S1', '', 'uploads/gambar_pegawai/pegawai2.jpg'),
(6, '198609262115051337', 'Jumarni', '1998-05-18', 'Banjarbaru', 'Teknisi', '2018-01-01', '', 'S1', '', 'uploads/gambar_pegawai/pegawai5.jpg'),
(7, '198609262115051338', 'Kusyanti', '1998-05-18', 'Banjarbaru', 'Teknisi', '2018-01-01', '', 'S1', '', 'uploads/gambar_pegawai/pegawai6.jpg'),
(8, '198609262015051003', 'Muhammad Syarif, S.ST', '1998-05-18', 'Banjarbaru', 'Teknisi', '2018-01-01', '', 'S1', '', 'uploads/gambar_pegawai/pegawai7.jpg');

INSERT INTO `manajemen_aset`.`jenis_aset` (
    nama
) VALUES 
('Aset Tidak Bergerak'),
('Aset Bergerak');

INSERT INTO `manajemen_aset`.`kategori_aset` (
    id_jenis_aset,
    nama
) VALUES 
(1, 'Tanah'),
(1, 'Bangunan'),
(2, 'Perlengkapan Olahraga'),
(2, 'Elektronik'),
(2, 'Kamera'),
(2, 'Kursi'),
(2, 'Meja'),
(2, 'Kendaraan');

INSERT INTO `manajemen_aset`.`aset`(
    id,
    id_kategori_aset,
    nama,
    jumlah 
) VALUES 
(1, 1, 'Sony', 0),
(2, 1, 'Sahitel ', 0),
(3, 1, 'Canon', 0),
(4, 4, 'Beat', 0),
(5, 4, 'Vario', 0),
(6, 4, 'NMAX', 0),
(7, 5, 'Avanza', 0),
(8, 5, 'BMW', 0),
(9, 5, 'Brio', 0);