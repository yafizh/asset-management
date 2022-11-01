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
('Mobil', 'Mobil jenis apapun yang ada di Balai Pengkajian Teknologi Pertanian Kalimantan Selatan.');

INSERT INTO sifat_aset(
    nama, 
    keterangan
) VALUES 
('Pemberian', 'Barang pemberian dari pihak manapun.'),
('Milik Kantor', 'Barang hasil beli dengan uang kas kantor');

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