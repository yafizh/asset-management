INSERT INTO pengguna (
    username,
    password,
    status
) VALUES 
('admin', 'admin', 'admin'),
('petugas', 'petugas', 'petugas'),
('18630320', '18630320', 'pegawai');

INSERT INTO jenis_aset(
    nama, 
    keterangan
) VALUES 
('Kamera', 'Kamera jenis apapun yang ada di Balai Pengkajian Teknologi Pertanian Kalimantan Selatan.'),
('Kursi', 'Kursi jenis apapun yang ada di Balai Pengkajian Teknologi Pertanian Kalimantan Selatan.'),
('Meja', 'Meja jenis apapun yang ada di Balai Pengkajian Teknologi Pertanian Kalimantan Selatan.'),
('Motor', 'Motor jenis apapun yang ada di Balai Pengkajian Teknologi Pertanian Kalimantan Selatan.'),
('Mobil', 'Mobil jenis apapun yang ada di Balai Pengkajian Teknologi Pertanian Kalimantan Selatan.');

INSERT INTO sifat_aset(
    nama, 
    keterangan
) VALUES 
('Pemberian', 'Barang pemberian dari pihak manapun.'),
('Milik Kantor', 'Barang hasil beli dengan uang kas kantor');

INSERT INTO aset(
    id_jenis_aset,
    id_sifat_aset,
    nama,
    tanggal_masuk,
    detail,
    foto,
    keterangan 
) VALUES 
(1, 2, 'Kamera 1', CURRENT_DATE(), '{"Merk": "Sony", "Warna": "Hitam", "Lensa": "Canon 50mm"}', 'uploads/gambar_aset/kamera1.webp', ''),
(1, 2, 'Kamera 2', CURRENT_DATE(), '{"Merk": "Fujifilm", "Warna": "Hitam Silver", "Lensa": "Fujinon 35mm"}', 'uploads/gambar_aset/kamera2.webp', ''),
(1, 2, 'Kamera 3', CURRENT_DATE(), '{"Warna": "Hitam Silver", "Lensa": "Fujinon 23mm"}', 'uploads/gambar_aset/kamera3.webp', ''),
(4, 2, 'Motor 1', CURRENT_DATE(), '{"Merk": "BMW", "Warna": "Putih Cokelat", "Plat": "CR 7", "Roda": "2 Roda", "Kondisi": "Baru"}', 'uploads/gambar_aset/motor1.webp', ''),
(4, 2, 'Motor 2', CURRENT_DATE(), '{"Merk": "Honda", "Warna": "Hitam", "Roda": "2 Roda", "Kondisi": "Baru"}', 'uploads/gambar_aset/motor2.webp', ''),
(4, 2, 'Motor 3', CURRENT_DATE(), '{"Merk": "Honda", "Warna": "Merah", "Roda": "2 Roda", "Kondisi": "Baru"}', 'uploads/gambar_aset/motor3.webp', ''),
(5, 2, 'Mobil 1', CURRENT_DATE(), '{"Warna": "Kuning", "Roda": "4 Roda", "Kondisi": "Lama"}', 'uploads/gambar_aset/mobil1.webp', ''),
(5, 2, 'Mobil 2', CURRENT_DATE(), '{"Warna": "Biru", "Roda": "4 Roda", "Kondisi": "Baru"}', 'uploads/gambar_aset/mobil2.webp', ''),
(5, 2, 'Mobil 3', CURRENT_DATE(), '{"Merk": "Ford", "Warna": "Putih", "Plat": "8CPP419", "Roda": "4 Roda", "Kondisi": "Baru"}', 'uploads/gambar_aset/mobil3.webp', '');

INSERT INTO pegawai(
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