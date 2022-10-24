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
</head>

<body class="g-sidenav-show  bg-gray-200">
    <?php include_once('komponen/sidebar.php'); ?>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <?php include_once('komponen/navbar.php'); ?>
        <div class="container-fluid py-4">
            <?php

            if (isset($_GET['h'])) {
                switch ($_GET['h']) {
                    case 'dashboard':
                        include_once('halaman/dashboard/index.php');
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
    <?php include_once('komponen/js.php'); ?>
</body>

</html>