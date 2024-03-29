<?php session_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .small-td {
            width: 1%;
            white-space: nowrap;
        }

        div {
            -webkit-print-color-adjust: exact;
        }
    </style>
</head>

<body>
    <header class="text-center p-4">
        <img src="../../../assets/img/favicon.png" alt="Logo" width="120" style="position: absolute; left: 20px;">
        <h4>BALAI PENGKAJIAN TEKNOLOGI PERTANIAN</h4>
        <h4>KALIMANTAN SELATAN</h4>
        Jl. Panglima Batur No.4, Loktabat Utara, Kec. Banjarbaru Utara, Kota Banjar Baru, Kalimantan Selatan 70711
        <br>
        Telepon: (0511) 4772346, Website: http://kalsel.litbang.pertanian.go.id/, Email:
        bptp-kalsel@litbang.pertanian.go.id
    </header>
    <div class="d-flex flex-column justify-content-center w-100">
        <div style="width: 100%; border-top: 3px solid black;"></div>
    </div>
    <?php
    include_once('../../../database/koneksi.php');
    include_once('../../../helper/date.php');

    if ($_GET['h'] === 'aset')
        include_once('halaman/aset.php');
    elseif ($_GET['h'] === 'aset_rusak')
        include_once('halaman/aset_rusak.php');
    elseif ($_GET['h'] === 'aset_hilang')
        include_once('halaman/aset_hilang.php');
    elseif ($_GET['h'] === 'aset_masuk')
        include_once('halaman/aset_masuk.php');
    elseif ($_GET['h'] === 'peminjaman_aset')
        include_once('halaman/peminjaman_aset.php');
    elseif ($_GET['h'] === 'pengembalian_aset')
        include_once('halaman/pengembalian_aset.php');
    elseif ($_GET['h'] === 'pegawai')
        include_once('halaman/pegawai.php');
    elseif ($_GET['h'] === 'grafik_peminjaman_aset')
        include_once('halaman/grafik_peminjaman_aset.php');
    elseif ($_GET['h'] === 'kondisi_aset')
        include_once('halaman/kondisi_aset.php');
    ?>

    <?php if ($_SESSION['user']['status'] == 1) : ?>
        <footer class="d-flex justify-content-end px-5">
            <div class="text-center">
                <h6>Banjarbaru, <?= tanggalIndonesia(Date("Y-m-d")); ?></h6>
                <br><br><br><br><br>
                <h6>ADMIN</h6>
            </div>
        </footer>
    <?php else : ?>
        <footer class="d-flex justify-content-end px-5">
            <div class="text-center">
                <h6>Banjarbaru, <?= tanggalIndonesia(Date("Y-m-d")); ?></h6>
                <br><br><br><br><br>
                <h6><?= $_SESSION['user']['nama']; ?></h6>
                <div style="width: 100%; background-color: black; height: .1rem;"></div>
                <h6><?= $_SESSION['user']['nip']; ?></h6>
            </div>
        </footer>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.print();
    </script>
</body>

</html>