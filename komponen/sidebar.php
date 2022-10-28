<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 ps bg-white" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
            <img src="./assets/img/favicon.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-dark">BPTP KALSEL</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?= isset($_GET['h']) ? ($_GET['h'] === 'dashboard' ? 'active bg-gradient-success text-white' : 'text-dark') : 'active text-white bg-gradient-success' ?>" href="?h=dashboard">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-8">Data Master</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= isset($_GET['h']) ? (in_array($_GET['h'], ['jenis_aset', 'tambah_jenis_aset', 'edit_jenis_aset', 'hapus_jenis_aset']) ? 'active bg-gradient-success text-white' : 'text-dark') : 'text-dark' ?>" href="?h=jenis_aset">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text ms-1">Jenis Aset</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= isset($_GET['h']) ? (in_array($_GET['h'], ['sifat_aset', 'tambah_sifat_aset', 'edit_sifat_aset', 'hapus_sifat_aset']) ? 'active bg-gradient-success text-white' : 'text-dark') : 'text-dark' ?>" href="?h=sifat_aset">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">login</i>
                    </div>
                    <span class="nav-link-text ms-1">Sifat Aset</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-8">Data Aset</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= isset($_GET['h']) ? (in_array($_GET['h'], ['aset', 'tambah_aset', 'edit_aset', 'aset_per_jenis_aset']) ? 'active bg-gradient-success text-white' : 'text-dark') : 'text-dark' ?>" href="?h=aset">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">table_view</i>
                    </div>
                    <span class="nav-link-text ms-1">Aset</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= isset($_GET['h']) ? ($_GET['h'] === 'peminjaman_aset' ? 'active bg-gradient-success text-white' : 'text-dark') : 'text-dark' ?>" href="?h=peminjaman_aset">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">notifications</i>
                    </div>
                    <span class="nav-link-text ms-1">Peminjaman Aset</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= isset($_GET['h']) ? ($_GET['h'] === 'aset_rusak' ? 'active bg-gradient-success text-white' : 'text-dark') : 'text-dark' ?>" href="?h=aset_rusak">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Aset Rusak</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark <?= isset($_GET['h']) ? ($_GET['h'] === 'aset_hilang' ? 'active bg-gradient-success text-white' : 'text-dark') : 'text-dark' ?>" href="?h=aset_hilang">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">view_in_ar</i>
                    </div>
                    <span class="nav-link-text ms-1">Aset Hilang</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= isset($_GET['h']) ? ($_GET['h'] === 'pemeliharaan_aset' ? 'active bg-gradient-success text-white' : 'text-dark') : 'text-dark' ?>" href="?h=pemeliharaan_aset">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                    </div>
                    <span class="nav-link-text ms-1">Pemeliharaan Aset</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="#">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">login</i>
                    </div>
                    <span class="nav-link-text ms-1">Keluar</span>
                </a>
            </li>
        </ul>
    </div>
</aside>