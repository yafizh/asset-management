<?php
session_start();
include_once('database/koneksi.php');
?>
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

        .modal table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
        }

        .modal table tr th,
        .modal table tr td {
            border-right: 1px solid #dee2e6 !important;
            border-bottom: 1px solid #dee2e6 !important;
        }

        .modal table tr th:first-child,
        .modal table tr td:first-child {
            border-left: 1px solid #dee2e6 !important;
        }

        .modal table tr th {
            border-top: 1px solid #dee2e6 !important;
        }


        .modal table tr:first-child th:first-child {
            border-top-left-radius: 0.5rem !important;
        }

        .modal table tr:first-child th:last-child {
            border-top-right-radius: 0.5rem !important;
        }

        .modal table tr:last-child td:first-child {
            border-bottom-left-radius: 0.5rem !important;
        }

        .modal table tr:last-child td:last-child {
            border-bottom-right-radius: 0.5rem !important;
        }

        .modal::-webkit-scrollbar {
            display: none;
        }

        .btn-secondary,
        .btn-secondary:hover,
        .btn-secondary:focus {
            box-shadow: none;
        }
    </style>
</head>

<body class="g-sidenav-show bg-gray-200">
    <?php
    // Route for Admin and Petugas
    if ($_SESSION['user']['status'] == 1 || $_SESSION['user']['status'] == 2 || $_SESSION['user']['status'] == 4) {
        if (isset($_GET['h'])) {
            // Laporan
            if ($_GET['h'] === 'laporan_pegawai') {
                $navbar = "Laporan Pegawai";
                $page = 'halaman/laporan/tampil/pegawai.php';
                $active = "laporan_pegawai";
            } elseif ($_GET['h'] === 'laporan_aset_masuk') {
                $navbar = "Laporan Penambahan Aset";
                $page = 'halaman/laporan/tampil/aset_masuk.php';
                $active = "laporan_aset_masuk";
            } elseif ($_GET['h'] === 'laporan_aset_rusak') {
                $navbar = "Laporan Aset Rusak";
                $page = 'halaman/laporan/tampil/aset_rusak.php';
                $active = "laporan_aset_rusak";
            } elseif ($_GET['h'] === 'laporan_aset_hilang') {
                $navbar = "Laporan Penambahan Hilang";
                $page = 'halaman/laporan/tampil/aset_hilang.php';
                $active = "laporan_aset_hilang";
            } elseif ($_GET['h'] === 'laporan_pemeliharaan_aset') {
                $page = 'halaman/laporan/tampil/pemeliharaan_aset.php';
                $active = "laporan_pemeliharaan_aset";
            } elseif ($_GET['h'] === 'laporan_peminjaman_aset') {
                $navbar = "Laporan Peminjaman Aset";
                $page = 'halaman/laporan/tampil/peminjaman_aset.php';
                $active = "laporan_peminjaman_aset";
            } elseif ($_GET['h'] === 'laporan_pengembalian_aset') {
                $navbar = "Laporan Pengembalian Aset";
                $page = 'halaman/laporan/tampil/pengembalian_aset.php';
                $active = "laporan_pengembalian_aset";
            } elseif ($_GET['h'] === 'laporan_grafik_peminjaman_aset') {
                $navbar = "Laporan Grafik Peminjaman Aset";
                $page = 'halaman/laporan/tampil/grafik_peminjaman_aset.php';
                $active = "laporan_grafik_peminjaman_aset";
            } elseif ($_GET['h'] === 'laporan_jumlah_aset') {
                $page = 'halaman/laporan/tampil/jumlah_aset.php';
                $active = "laporan_jumlah_aset";
            } elseif ($_GET['h'] === 'laporan_aset') {
                $page = 'halaman/laporan/tampil/aset.php';
                $active = "laporan_aset";
            } elseif ($_GET['h'] === 'laporan_kondisi_aset') {
                $page = 'halaman/laporan/tampil/kondisi_aset.php';
                $active = "laporan_kondisi_aset";
            } elseif ($_GET['h'] === 'laporan_aset') {
                $page = 'halaman/laporan/tampil/aset.php';
                $active = "laporan_aset";
            }

            // Ganti Password
            if ($_GET['h'] === 'ganti_password') {
                $active = 'ganti_password';
                $page = 'halaman/ganti_password/index.php';
            }

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
            if (in_array($_GET['h'], ['pegawai', 'tambah_pegawai', 'edit_pegawai', 'hapus_pegawai', 'detail_pegawai'])) $active = 'pegawai';

            if ($_GET['h'] === 'pegawai') $page = 'halaman/pegawai/index.php';
            elseif ($_GET['h'] === 'tambah_pegawai') $page = 'halaman/pegawai/tambah.php';
            elseif ($_GET['h'] === 'edit_pegawai') $page = 'halaman/pegawai/edit.php';
            elseif ($_GET['h'] === 'hapus_pegawai') $page = 'halaman/pegawai/hapus.php';
            elseif ($_GET['h'] === 'detail_pegawai') $page = 'halaman/pegawai/detail.php';

            // Jenis Aset
            if (in_array($_GET['h'], ['jenis_aset'])) $active = 'aset';

            if ($_GET['h'] === 'jenis_aset') {
                $navbar = "Jenis Aset";
                $page = 'halaman/jenis_aset/index.php';
            };

            // Kategori Aset
            if (in_array($_GET['h'], ['kategori_aset'])) $active = 'aset';

            if ($_GET['h'] === 'kategori_aset') {
                $jenis_aset = $mysqli->query("SELECT * FROM jenis_aset WHERE id=" . $_GET['id_jenis_aset'])->fetch_assoc();
                $navbar = "<a href='?h=jenis_aset'>Jenis Aset</a> \\ " . $jenis_aset['nama'] . "";
                $page = 'halaman/kategori_aset/index.php';
            }

            // Aset
            if (in_array($_GET['h'], ['aset', 'tambah_aset', 'edit_aset', 'hapus_aset', 'detail_aset', 'aset_per_kategori_aset'])) $active = 'aset';

            if (in_array($_GET['h'], ['aset', 'tambah_aset', 'edit_aset', 'detail_aset'])) {
                $jenis_aset = $mysqli->query("SELECT * FROM jenis_aset WHERE id=" . $_GET['id_jenis_aset'])->fetch_assoc();
                $kategori_aset = $mysqli->query("SELECT * FROM kategori_aset WHERE id=" . $_GET['id_kategori_aset'])->fetch_assoc();
                $navbar = "<a href='?h=jenis_aset'>Jenis Aset</a> \\ <span class='text-muted'>" . $jenis_aset['nama'] . "</span> \\ <a href='?h=kategori_aset&id_jenis_aset=" . $jenis_aset['id'] . "'>Ketegori Aset</a> \\ <span class='text-muted'>" . $kategori_aset['nama'] . "</span>";
            }

            if ($_GET['h'] === 'aset') $page = 'halaman/aset/index.php';
            elseif ($_GET['h'] === 'tambah_aset') $page = 'halaman/aset/tambah.php';
            elseif ($_GET['h'] === 'edit_aset') $page = 'halaman/aset/edit.php';
            elseif ($_GET['h'] === 'hapus_aset') $page = 'halaman/aset/hapus.php';
            elseif ($_GET['h'] === 'detail_aset') $page = 'halaman/aset/detail_aset.php';

            // Aset Rusak
            if (in_array($_GET['h'], ['aset_rusak', 'tambah_aset_rusak', 'hapus_aset_rusak'])) {
                $navbar = "Aset Rusak";
                $active = 'aset_rusak';
                $navbar = "Aset Rusak";
            }

            if ($_GET['h'] === 'aset_rusak') $page = 'halaman/aset_rusak/index.php';
            elseif ($_GET['h'] === 'tambah_aset_rusak') $page = 'halaman/aset_rusak/tambah.php';
            elseif ($_GET['h'] === 'hapus_aset_rusak') $page = 'halaman/aset_rusak/hapus.php';

            // Aset Hilang
            if (in_array($_GET['h'], ['aset_hilang', 'tambah_aset_hilang', 'hapus_aset_hilang'])) {
                $navbar = "Aset Hilang";
                $active = 'aset_hilang';
                $navbar = "Aset Hilang";
            }

            if ($_GET['h'] === 'aset_hilang') $page = 'halaman/aset_hilang/index.php';
            elseif ($_GET['h'] === 'tambah_aset_hilang') $page = 'halaman/aset_hilang/tambah.php';
            elseif ($_GET['h'] === 'hapus_aset_hilang') $page = 'halaman/aset_hilang/hapus.php';

            // Aset Masuk
            if (in_array($_GET['h'], ['aset_masuk', 'tambah_aset_masuk', 'hapus_aset_masuk'])) {
                $navbar = "Penambahan Aset";
                $active = 'aset_masuk';
                $navbar = "Penambahan Aset";
            }

            if ($_GET['h'] === 'aset_masuk') $page = 'halaman/aset_masuk/index.php';
            elseif ($_GET['h'] === 'tambah_aset_masuk') $page = 'halaman/aset_masuk/tambah.php';
            elseif ($_GET['h'] === 'hapus_aset_masuk') $page = 'halaman/aset_masuk/hapus.php';

            // Pemeliharaan Aset
            if (in_array($_GET['h'], ['pemeliharaan_aset', 'tambah_pemeliharaan_aset', 'aset_sedang_pemeliharaan', 'aset_selesai_pemeliharaan', 'detail_pemeliharaan_aset', 'pemeliharaan_aset_selesai'])) $active = 'pemeliharaan_aset';

            if ($_GET['h'] === 'pemeliharaan_aset') $page = 'halaman/pemeliharaan_aset/index.php';
            elseif ($_GET['h'] === 'tambah_pemeliharaan_aset') $page = 'halaman/pemeliharaan_aset/tambah.php';
            elseif ($_GET['h'] === 'edit_pemeliharaan_aset') $page = 'halaman/pemeliharaan_aset/edit.php';
            elseif ($_GET['h'] === 'detail_pemeliharaan_aset') $page = 'halaman/pemeliharaan_aset/detail_aset.php';
            elseif ($_GET['h'] === 'aset_sedang_pemeliharaan') $page = 'halaman/pemeliharaan_aset/index_aset_sedang_pemeliharaan.php';
            elseif ($_GET['h'] === 'aset_selesai_pemeliharaan') $page = 'halaman/pemeliharaan_aset/index_aset_selesai_pemeliharaan.php';
            elseif ($_GET['h'] === 'pemeliharaan_aset_selesai') $page = 'halaman/pemeliharaan_aset/pemeliharaan_selesai.php';

            // Kelola Peminjaman Aset
            if (in_array($_GET['h'], ['aset_tersedia', 'aset_tersedia_per_kategori_aset', 'detail_aset_tersedia'])) $active = 'aset_tersedia';
            if ($_GET['h'] === 'aset_tersedia') $page = 'halaman/kelola_peminjaman_aset/aset_tersedia/index.php';
            elseif ($_GET['h'] === 'detail_aset_tersedia') $page = 'halaman/kelola_peminjaman_aset/aset_tersedia/detail.php';
            elseif ($_GET['h'] === 'aset_tersedia_per_kategori_aset') $page = 'halaman/kelola_peminjaman_aset/aset_tersedia/index_per_kategori_aset.php';

            if (in_array($_GET['h'], ['aset_dipinjam', 'aset_dipinjam_per_kategori_aset', 'detail_aset_dipinjam'])) $active = 'aset_dipinjam';
            if ($_GET['h'] === 'aset_dipinjam') $page = 'halaman/kelola_peminjaman_aset/aset_dipinjam/index.php';
            elseif ($_GET['h'] === 'detail_aset_dipinjam') $page = 'halaman/kelola_peminjaman_aset/aset_dipinjam/detail.php';
            elseif ($_GET['h'] === 'aset_dipinjam_per_kategori_aset') $page = 'halaman/kelola_peminjaman_aset/aset_dipinjam/index_per_kategori_aset.php';

            if (in_array($_GET['h'], ['pengajuan_peminjaman_aset', 'detail_pengajuan_peminjaman_aset'])) {
                $navbar = "Pengajuan Peminjaman Aset";
                $active = 'pengajuan_peminjaman_aset';
            }
            if ($_GET['h'] === 'pengajuan_peminjaman_aset') $page = 'halaman/kelola_peminjaman_aset/pengajuan_peminjaman_aset/index.php';
            elseif ($_GET['h'] === 'detail_pengajuan_peminjaman_aset') $page = 'halaman/kelola_peminjaman_aset/pengajuan_peminjaman_aset/detail.php';

            if (in_array($_GET['h'], ['pengajuan_pengembalian_aset', 'detail_pengajuan_pengembalian_aset'])) {
                $navbar = "Pengajuan Peminjaman Aset";
                $active = 'pengajuan_pengembalian_aset';
            }
            if ($_GET['h'] === 'pengajuan_pengembalian_aset') $page = 'halaman/kelola_peminjaman_aset/pengajuan_pengembalian_aset/index.php';
            elseif ($_GET['h'] === 'detail_pengajuan_pengembalian_aset') $page = 'halaman/kelola_peminjaman_aset/pengajuan_pengembalian_aset/detail.php';
        } else {
            if ($_SESSION['user']['status'] == 1) {
                $navbar = "Jenis Aset";
                $active = "pegawai";
                $page = 'halaman/pegawai/index.php';
            }
            if ($_SESSION['user']['status'] == 2) {
                $navbar = "Jenis Aset";
                $active = "aset";
                $page = 'halaman/jenis_aset/index.php';
            }
            if ($_SESSION['user']['status'] == 4) {
                $page = 'halaman/laporan/tampil/aset.php';
                $active = "laporan_aset";
                $navbar = "Laporan Aset";
            }
            // $active = 'dashboard';
            // $page = 'halaman/dashboard/index.php';
        }
    }

    // Route for Pegawai
    if ($_SESSION['user']['status'] == 3) {
        if (isset($_GET['h'])) {
            if ($_GET['h'] === 'ganti_password') {
                $active = 'Ganti Password';
                $page = 'halaman/ganti_password/index.php';
            } else if ($_GET['h'] === 'kategori_aset') {
                $jenis_aset = $mysqli->query("SELECT * FROM jenis_aset WHERE id=" . $_GET['id_jenis_aset'])->fetch_assoc();
                $navbar = "<a href='?h=jenis_aset'>Jenis Aset</a> \\ <span class='text-muted'>" . $jenis_aset['nama'] . "</span>";
                $page = "halaman/kategori_aset/index.php";
            } else if ($_GET['h'] === 'aset') {
                $jenis_aset = $mysqli->query("SELECT * FROM jenis_aset WHERE id=" . $_GET['id_jenis_aset'])->fetch_assoc();
                $kategori_aset = $mysqli->query("SELECT * FROM kategori_aset WHERE id=" . $_GET['id_kategori_aset'])->fetch_assoc();
                $navbar = "<a href='?h=jenis_aset'>Jenis Aset</a> \\ <span class='text-muted'>" . $jenis_aset['nama'] . "</span> \\ <a href='?h=kategori_aset&id_jenis_aset=" . $jenis_aset['id'] . "'>Ketegori Aset</a> \\ <span class='text-muted'>" . $kategori_aset['nama'] . "</span>";
                $page = "halaman/peminjaman_aset/index.php";
            } else if ($_GET['h'] === 'pengajuan_peminjaman') {
                $navbar = "Pengajuan Peminjaman Aset";
                $page = "halaman/peminjaman_aset/pengajuan_peminjaman.php";
            } else if ($_GET['h'] === 'pengajuan_pengembalian') {
                $navbar = "Pengajuan Pengembalian Aset";
                $page = "halaman/peminjaman_aset/pengajuan_pengembalian.php";
            } elseif ($_GET['h'] === 'riwayat_peminjaman_aset') {
                $navbar = "Data Peminjaman Aset";
                $page = "halaman/riwayat_peminjaman_aset/index.php";
            } elseif ($_GET['h'] === 'detail_riwayat_peminjaman_aset') {
                $navbar = "Detail Peminjaman Aset";
                $page = "halaman/riwayat_peminjaman_aset/detail.php";
            } elseif ($_GET['h'] === 'riwayat_pengembalian_aset') {
                $navbar = "Data Pengembalian Aset";
                $page = "halaman/riwayat_pengembalian_aset/index.php";
            } elseif ($_GET['h'] === 'detail_riwayat_pengembalian_aset') {
                $navbar = "Detail Pengembalian Aset";
                $page = "halaman/riwayat_pengembalian_aset/detail.php";
            } else {
                $navbar = "Jenis Aset";
                $page = 'halaman/jenis_aset/index.php';
            }
        } else {
            $navbar = "Jenis Aset";
            $page = 'halaman/jenis_aset/index.php';
        }
    }
    ?>
    <?php
    if ($_SESSION['user']['status'] == 1 || $_SESSION['user']['status'] == 2 || $_SESSION['user']['status'] == 4) include_once('komponen/sidebar.php'); ?>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <?php include_once('komponen/navbar.php'); ?>
        <div class="container-fluid py-4">
            <?php
            include_once('helper/date.php');
            include_once($page);
            ?>
        </div>
    </main>
</body>

</html>