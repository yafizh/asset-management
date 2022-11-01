<?php session_start(); ?>
<?php

if (!isset($_SESSION['user'])) {
    echo "<script>location.href = 'halaman/login';</script>";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <title>BPTP KALSEL</title>
    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="./assets/css/material-dashboard.css?v=3.0.4" rel="stylesheet" />
    <!-- Data Tables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

    <?php include_once('komponen/js.php'); ?>
    <style>
        .small-td {
            width: 1%;
            white-space: nowrap;
        }

        .pagination>li.active>a,
        .pagination>li.active>span {
            background-color: #66BB6A;
            border: #66BB6A;
        }

        .pagination>li:not(.active)>a:hover,
        .pagination>li:not(.active)>span:hover,
        .pagination>li>a:focus,
        .pagination>li>span:focus {
            color: #66BB6A;
        }
    </style>
</head>

<body class="g-sidenav-show bg-gray-200">
    <?php
    // Route for Admin and Petugas
    if ($_SESSION['user']['status'] === 'admin' || $_SESSION['user']['status'] === 'petugas') {
        if (isset($_GET['h'])) {
            // Dashboard
            if ($_GET['h'] === 'dashboard') {
                $active = 'dashboard';
                $page = 'halaman/dashboard/index.php';
            }

            // Pengguna
            if (in_array($_GET['h'], ['pengguna', 'tambah_pengguna', 'edit_pengguna', 'hapus_pengguna'])) $active = 'pengguna';

            if ($_GET['h'] === 'pengguna') $page = 'halaman/pengguna/index.php';
            elseif ($_GET['h'] === 'tambah_pengguna') $page = 'halaman/pengguna/tambah.php';
            elseif ($_GET['h'] === 'edit_pengguna') $page = 'halaman/pengguna/edit.php';
            elseif ($_GET['h'] === 'hapus_pengguna') $page = 'halaman/pengguna/hapus.php';

            // Pegawai
            if (in_array($_GET['h'], ['pegawai', 'tambah_pegawai', 'edit_pegawai', 'hapus_pegawai'])) $active = 'pegawai';

            if ($_GET['h'] === 'pegawai') $page = 'halaman/pegawai/index.php';
            elseif ($_GET['h'] === 'tambah_pegawai') $page = 'halaman/pegawai/tambah.php';
            elseif ($_GET['h'] === 'edit_pegawai') $page = 'halaman/pegawai/edit.php';
            elseif ($_GET['h'] === 'hapus_pegawai') $page = 'halaman/pegawai/hapus.php';

            // Jenis Aset
            if (in_array($_GET['h'], ['jenis_aset', 'tambah_jenis_aset', 'edit_jenis_aset', 'hapus_jenis_aset'])) $active = 'jenis_aset';

            if ($_GET['h'] === 'jenis_aset') $page = 'halaman/jenis_aset/index.php';
            elseif ($_GET['h'] === 'tambah_jenis_aset') $page = 'halaman/jenis_aset/tambah.php';
            elseif ($_GET['h'] === 'edit_jenis_aset') $page = 'halaman/jenis_aset/edit.php';
            elseif ($_GET['h'] === 'hapus_jenis_aset') $page = 'halaman/jenis_aset/hapus.php';

            // Sifat Aset
            if (in_array($_GET['h'], ['sifat_aset', 'tambah_sifat_aset', 'edit_sifat_aset', 'hapus_sifat_aset'])) $active = 'sifat_aset';

            if ($_GET['h'] === 'sifat_aset') $page = 'halaman/sifat_aset/index.php';
            elseif ($_GET['h'] === 'tambah_sifat_aset') $page = 'halaman/sifat_aset/tambah.php';
            elseif ($_GET['h'] === 'edit_sifat_aset') $page = 'halaman/sifat_aset/edit.php';
            elseif ($_GET['h'] === 'hapus_sifat_aset') $page = 'halaman/sifat_aset/hapus.php';

            // Aset
            if (in_array($_GET['h'], ['aset', 'tambah_aset', 'edit_aset', 'hapus_aset', 'detail_aset', 'aset_per_jenis_aset'])) $active = 'aset';

            if ($_GET['h'] === 'aset') $page = 'halaman/aset/index.php';
            elseif ($_GET['h'] === 'tambah_aset') $page = 'halaman/aset/tambah.php';
            elseif ($_GET['h'] === 'edit_aset') $page = 'halaman/aset/edit.php';
            elseif ($_GET['h'] === 'hapus_aset') $page = 'halaman/aset/hapus.php';
            elseif ($_GET['h'] === 'detail_aset') $page = 'halaman/aset/detail_aset.php';
            elseif ($_GET['h'] === 'aset_per_jenis_aset') $page = 'halaman/aset/index_per_jenis_aset.php';

            // Aset Rusak
            if (in_array($_GET['h'], ['aset_rusak', 'tambah_aset_rusak', 'hapus_aset_rusak', 'detail_aset_rusak', 'aset_rusak_per_jenis_aset'])) $active = 'aset_rusak';

            if ($_GET['h'] === 'aset_rusak') $page = 'halaman/aset_rusak/index.php';
            elseif ($_GET['h'] === 'tambah_aset_rusak') $page = 'halaman/aset_rusak/tambah.php';
            elseif ($_GET['h'] === 'hapus_aset_rusak') $page = 'halaman/aset_rusak/hapus.php';
            elseif ($_GET['h'] === 'detail_aset_rusak') $page = 'halaman/aset_rusak/detail_aset.php';
            elseif ($_GET['h'] === 'aset_rusak_per_jenis_aset') $page = 'halaman/aset_rusak/index_per_jenis_aset.php';

            // Aset Hilang
            if (in_array($_GET['h'], ['aset_hilang', 'tambah_aset_hilang', 'hapus_aset_hilang', 'detail_aset_hilang', 'aset_hilang_per_jenis_aset'])) $active = 'aset_hilang';

            if ($_GET['h'] === 'aset_hilang') $page = 'halaman/aset_hilang/index.php';
            elseif ($_GET['h'] === 'tambah_aset_hilang') $page = 'halaman/aset_hilang/tambah.php';
            elseif ($_GET['h'] === 'hapus_aset_hilang') $page = 'halaman/aset_hilang/hapus.php';
            elseif ($_GET['h'] === 'detail_aset_hilang') $page = 'halaman/aset_hilang/detail_aset.php';
            elseif ($_GET['h'] === 'aset_hilang_per_jenis_aset') $page = 'halaman/aset_hilang/index_per_jenis_aset.php';

            // Pemeliharaan Aset
            if (in_array($_GET['h'], ['pemeliharaan_aset', 'tambah_pemeliharaan_aset', 'aset_sedang_pemeliharaan', 'aset_selesai_pemeliharaan', 'detail_pemeliharaan_aset', 'pemeliharaan_aset_selesai'])) $active = 'pemeliharaan_aset';

            if ($_GET['h'] === 'pemeliharaan_aset') $page = 'halaman/pemeliharaan_aset/index.php';
            elseif ($_GET['h'] === 'tambah_pemeliharaan_aset') $page = 'halaman/pemeliharaan_aset/tambah.php';
            elseif ($_GET['h'] === 'edit_pemeliharaan_aset') $page = 'halaman/pemeliharaan_aset/edit.php';
            elseif ($_GET['h'] === 'detail_pemeliharaan_aset') $page = 'halaman/pemeliharaan_aset/detail_aset.php';
            elseif ($_GET['h'] === 'aset_sedang_pemeliharaan') $page = 'halaman/pemeliharaan_aset/index_aset_sedang_pemeliharaan.php';
            elseif ($_GET['h'] === 'aset_selesai_pemeliharaan') $page = 'halaman/pemeliharaan_aset/index_aset_selesai_pemeliharaan.php';
            elseif ($_GET['h'] === 'pemeliharaan_aset_selesai') $page = 'halaman/pemeliharaan_aset/pemeliharaan_selesai.php';
        } else {
            $active = 'dashboard';
            $page = 'halaman/dashboard/index.php';
        }
    }

    // Route for Pegawai
    if ($_SESSION['user']['status'] === 'pegawai') {
        if (isset($_GET['h'])) {
        } else
            $page = 'halaman/peminjaman_aset/index.php';
    }
    ?>
    <?php
    if ($_SESSION['user']['status'] === 'admin' || $_SESSION['user']['status'] === 'petugas') include_once('komponen/sidebar.php'); ?>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <?php if ($_SESSION['user']['status'] === 'pegawai') include_once('komponen/navbar.php'); ?>
        <div class="container-fluid py-4">
            <?php
            include_once('database/koneksi.php');
            include_once('helper/date.php');
            include_once($page);
            ?>
        </div>
    </main>
</body>

</html>