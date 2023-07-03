<?php

if (isset($_POST['submit'])) {
  session_start();
  include_once('../../database/koneksi.php');
  $nip = $mysqli->real_escape_string($_POST['nip']);
  $password = $mysqli->real_escape_string($_POST['password']);

  $query = "
    SELECT 
      pengguna.*,
      pegawai.nip,
      pegawai.nama
    FROM
      pengguna  
    LEFT JOIN   
      pegawai 
    ON 
      pegawai.id_pengguna=pengguna.id 
    WHERE 
      username='$nip' AND password='$password'
  ";
  $result = $mysqli->query($query);

  if ($result->num_rows) {
    $_SESSION['user'] = $result->fetch_assoc();
    echo "<script>location.href = '../../index.php';</script>";
    exit;
  }

  echo "<script>alert('Username atau Password Salah!')</script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Halaman Login
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="../../assets/css/material-dashboard.css?v=3.0.4" rel="stylesheet" />
  <style>
    .input-group.input-group-outline.is-focused .form-label,
    .input-group.input-group-outline.is-filled .form-label {
      width: 100%;
      height: 100%;
      font-size: 0.6875rem !important;
      color: #58B05C;
      display: flex;
      line-height: 1.25 !important;
    }

    .input-group.input-group-outline.is-focused .form-label+.form-control,
    .input-group.input-group-outline.is-filled .form-label+.form-control {
      border-color: #58B05C !important;
      border-top-color: transparent !important;
      box-shadow: inset 1px 0 #58B05C, inset -1px 0 #58B05C, inset 0 -1px #58B05C;
    }

    .input-group.input-group-outline.is-focused .form-label:before,
    .input-group.input-group-outline.is-focused .form-label:after,
    .input-group.input-group-outline.is-filled .form-label:before,
    .input-group.input-group-outline.is-filled .form-label:after {
      border-top-color: #58B05C;
      box-shadow: inset 0 1px #58B05C;
    }
  </style>
</head>

<body class="bg-gray-200">
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('../../assets/img/bg-pricing.jpg');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-6 col-xl-5 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Aplikasi Pengelola Ketersediaan dan Peminjaman Aset pada Balai Pengkajian Teknologi Pertanian Kalimantan Selatan</h4>
                </div>
              </div>
              <div class="card-body">
                <form action="" method="POST" role="form" class="text-start">
                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">NIP</label>
                    <input type="text" class="form-control" name="nip" autofocus required>
                  </div>
                  <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                  </div>
                  <div class="text-center">
                    <button type="submit" name="submit" class="btn bg-gradient-success w-100 my-4 mb-2">Masuk</button>
                  </div>
                  <p class="mt-4 text-sm text-center">
                    <a href="#" class="text-dark text-gradient font-weight-bold" onclick="alert('Hubungi Admin!');">Lupa Password</a>
                  </p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </main>
  <!--   Core JS Files   -->
  <script src="../../assets/js/core/popper.min.js"></script>
  <script src="../../assets/js/core/bootstrap.min.js"></script>
  <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../../assets/js/material-dashboard.min.js?v=3.0.4"></script>
</body>

</html>