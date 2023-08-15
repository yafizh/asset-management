INSERT INTO `manajemen_aset`.`pengguna` (
    username,
    password,
    status
) VALUES 
('admin', 'admin', 1),
('1', '1', 1),
('2', '2', 2),
('3', '3', 3),
('4', '4', 4),
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
    foto,
    pangkat_golongan 
) VALUES 
(2, '1', 'Muhammad Ali', '1998-05-18', 'Banjarbaru', 'Penyuluh Pertanian Pertama', '2018-01-01', '', 'SMA/SMK', '', 'uploads/gambar_pegawai/pegawai1.jpg', 'III/a'),
(3, '2', 'Agus Setiati', '1998-05-18', 'Banjarbaru', 'Penata Muda', '2018-01-01', '', 'S1', '', 'uploads/gambar_pegawai/pegawai3.jpg', 'III/a'),
(4, '3', 'Ahmad Isa Anshari, SE', '1998-05-18', 'Banjarbaru', 'Penata Muda', '2018-01-01', '', 'S1', '', 'uploads/gambar_pegawai/pegawai4.jpg', 'III/a'),
(5, '4', 'Juhdy', '1998-05-18', 'Banjarbaru', 'Penata Muda', '2018-01-01', '', 'S1', '', 'uploads/gambar_pegawai/pegawai2.jpg', 'III/a'),
(6, '198609262115051337', 'Jumarni', '1998-05-18', 'Banjarbaru', 'Teknisi', '2018-01-01', '', 'S1', '', 'uploads/gambar_pegawai/pegawai5.jpg', 'III/a'),
(7, '198609262115051338', 'Kusyanti', '1998-05-18', 'Banjarbaru', 'Teknisi', '2018-01-01', '', 'S1', '', 'uploads/gambar_pegawai/pegawai6.jpg', 'III/a'),
(8, '198609262015051003', 'Muhammad Syarif, S.ST', '1998-05-18', 'Banjarbaru', 'Teknisi', '2018-01-01', '', 'S1', '', 'uploads/gambar_pegawai/pegawai7.jpg','III/b');

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

INSERT INTO `manajemen_aset`.`aset` (
    `id_kategori_aset`, 
    `nama`,
    `jumlah`,
    `lokasi`,
    `tanggal` 
) VALUES
(2, 'Kantor BPTP KALSEL', 0, '', '2018-01-01'),
(8, 'Absolute Revo ', 0, '', '2018-01-01'),
(8, 'Thunder', 0, '', '2018-01-01'),
(8, 'Klx', 0, '', '2018-01-01'),
(8, 'Inova Reborn ', 0, '', '2018-01-01'),
(8, 'Hilux', 0, '', '2018-01-01'),
(8, 'Kijang Kapsul Lgx', 0, '', '2018-01-01'),
(5, 'canon 1200d', 0, '', '2018-01-01'),
(5, 'Sony a6000', 0, '', '2018-01-01'),
(4, 'Speaker Advance 18 inch', 0, '', '2018-01-01'),
(4, 'Proyektor Sony Vpl dx102', 0, '', '2018-01-01'),
(4, 'Printer Epson l3110', 0, '', '2018-01-01'),
(4, 'Scanner canon mp287', 0, '', '2018-01-01'),
(3, 'Meja Tenis Meja ', 0, '', '2018-01-01'),
(3, 'Papan Catur ', 0, '', '2018-01-01'),
(2, 'Lapangan Badminton ', 0, '', '2018-01-01'),
(2, 'Lapangan Tenis', 0, '', '2018-01-01'),
(3, 'Net badminton ', 0, '', '2018-01-01'),
(1, 'Taman Agro Inofasi', 0, '', '2018-01-01');