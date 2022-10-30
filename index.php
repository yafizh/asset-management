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

<body class="g-sidenav-show  bg-gray-200">
    <?php
    if (isset($_GET['h'])) {
        // Dashboard
        if ($_GET['h'] === 'dashboard') {
            $active = 'dashboard';
            $page = 'halaman/dashboard/index.php';
        }

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
        if (in_array($_GET['h'], ['aset_rusak', 'tambah_aset_rusak', 'edit_aset_rusak', 'hapus_aset_rusak', 'detail_aset_rusak', 'aset_rusak_per_jenis_aset'])) $active = 'aset_rusak';

        if ($_GET['h'] === 'aset_rusak') $page = 'halaman/aset_rusak/index.php';
        elseif ($_GET['h'] === 'tambah_aset_rusak') $page = 'halaman/aset_rusak/tambah.php';
        elseif ($_GET['h'] === 'edit_aset_rusak') $page = 'halaman/aset_rusak/edit.php';
        elseif ($_GET['h'] === 'hapus_aset_rusak') $page = 'halaman/aset_rusak/hapus.php';
        elseif ($_GET['h'] === 'detail_aset_rusak') $page = 'halaman/aset_rusak/detail_aset.php';
        elseif ($_GET['h'] === 'aset_rusak_per_jenis_aset') $page = 'halaman/aset_rusak/index_per_jenis_aset.php';
    } else {
        $active = 'dashboard';
        $page = 'halaman/dashboard/index.php';
    }
    ?>
    <?php include_once('komponen/sidebar.php'); ?>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <?php # include_once('komponen/navbar.php'); 
        ?>
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