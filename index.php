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
            padding-right: 2rem !important;
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

<body class="g-sidenav-show  bg-gray-200">
    <?php include_once('komponen/sidebar.php'); ?>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <?php include_once('komponen/navbar.php'); ?>
        <div class="container-fluid py-4">
            <?php
            include_once('database/koneksi.php');
            if (isset($_GET['h'])) {
                switch ($_GET['h']) {
                    case 'dashboard':
                        include_once('halaman/dashboard/index.php');
                        break;
                        // Pengguna
                    case 'pengguna':
                        include_once('halaman/pengguna/index.php');
                        break;
                    case 'tambah_pengguna':
                        include_once('halaman/pengguna/tambah.php');
                        break;
                    case 'edit_pengguna':
                        include_once('halaman/pengguna/edit.php');
                        break;
                    case 'hapus_pengguna':
                        include_once('halaman/pengguna/hapus.php');
                        break;
                        // Jenis Aset
                    case 'jenis_aset':
                        include_once('halaman/jenis_aset/index.php');
                        break;
                    case 'tambah_jenis_aset':
                        include_once('halaman/jenis_aset/tambah.php');
                        break;
                    case 'edit_jenis_aset':
                        include_once('halaman/jenis_aset/edit.php');
                        break;
                    case 'hapus_jenis_aset':
                        include_once('halaman/jenis_aset/hapus.php');
                        break;
                        // Sifat Aset
                    case 'sifat_aset':
                        include_once('halaman/sifat_aset/index.php');
                        break;
                    case 'tambah_sifat_aset':
                        include_once('halaman/sifat_aset/tambah.php');
                        break;
                    case 'edit_sifat_aset':
                        include_once('halaman/sifat_aset/edit.php');
                        break;
                    case 'hapus_sifat_aset':
                        include_once('halaman/sifat_aset/hapus.php');
                        break;
                        // Aset
                    case 'aset':
                        include_once('halaman/aset/index.php');
                        break;
                    case 'detail_aset':
                        include_once('halaman/aset/detail_aset.php');
                        break;
                    case 'detail_per_aset':
                        include_once('halaman/aset/detail_per_aset.php');
                        break;
                    case 'tambah_aset':
                        include_once('halaman/aset/tambah.php');
                        break;
                    case 'edit_aset':
                        include_once('halaman/aset/edit.php');
                        break;
                    case 'hapus_aset':
                        include_once('halaman/aset/hapus.php');
                        break;
                        // Aset Rusak
                    case 'aset_rusak':
                        include_once('halaman/aset_rusak/index.php');
                        break;
                    case 'tambah_aset_rusak':
                        include_once('halaman/aset_rusak/tambah.php');
                        break;
                    case 'edit_aset_rusak':
                        include_once('halaman/aset_rusak/edit.php');
                        break;
                    case 'hapus_aset_rusak':
                        include_once('halaman/aset_rusak/hapus.php');
                        break;
                        // Aset Hilang
                    case 'aset_hilang':
                        include_once('halaman/aset_hilang/index.php');
                        break;
                    case 'tambah_aset_hilang':
                        include_once('halaman/aset_hilang/tambah.php');
                        break;
                    case 'edit_aset_hilang':
                        include_once('halaman/aset_hilang/edit.php');
                        break;
                    case 'hapus_aset_hilang':
                        include_once('halaman/aset_hilang/hapus.php');
                        break;
                        // Pemeliharaan Aset
                    case 'pemeliharaan_aset':
                        include_once('halaman/pemeliharaan_aset/index.php');
                        break;
                    case 'tambah_pemeliharaan_aset':
                        include_once('halaman/pemeliharaan_aset/tambah.php');
                        break;
                    case 'edit_pemeliharaan_aset':
                        include_once('halaman/pemeliharaan_aset/edit.php');
                        break;
                    case 'hapus_pemeliharaan_aset':
                        include_once('halaman/pemeliharaan_aset/hapus.php');
                        break;
                    default:
                        include_once('halaman/dashboard/index.php');
                }
            } else
                include_once('halaman/dashboard/index.php');
            ?>
            <?php include_once('komponen/footer.php'); ?>
        </div>
    </main>
</body>

</html>