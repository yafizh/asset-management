INSERT INTO pengguna (
    username,
    password,
    status
) VALUES 
('admin', 'admin', 'admin');

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