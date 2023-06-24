<style>
    /* Search Input On Navbar */
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

    /* Dropdown Navbar */
    #dropdown-menu-custome .dropdown-item:focus,
    #dropdown-menu-custome .dropdown-item:hover {
        color: white !important;
        background-color: #58B05C !important;
    }
</style>
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl bg-light mt-4" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
        <div class="collapse navbar-collapse mt-sm-0 me-md-0 me-sm-4" id="navbar">
            <div class="w-100 pe-md-5 d-flex align-items-center">
                <h5 class="m-0"><?= $navbar ?? ''; ?></h5>
            </div>
            <ul class="ms-3 navbar-nav justify-content-end" style="flex: 1;">
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-success p-0 text-center" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bars"></i> Menu
                    </a>
                    <ul id="dropdown-menu-custome" class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                        <li class="mb-2 text-center">
                            <h6><?= $_SESSION['user']['nip'] ?></h6>
                            <h6><?= $_SESSION['user']['nama'] ?></h6>
                            <h6 class="text-muted">
                                <?php if ($_SESSION['user']['status'] == 1) : ?>
                                    Admin
                                <?php elseif ($_SESSION['user']['status'] == 2) : ?>
                                    Petugas
                                <?php elseif ($_SESSION['user']['status'] == 3) : ?>
                                    Pegawai
                                <?php elseif ($_SESSION['user']['status'] == 4) : ?>
                                    Kepala Balai
                                <?php endif; ?>
                            </h6>
                        </li>
                        <hr>
                        <?php if ($_SESSION['user']['status'] == 3) : ?>
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md focus-color" href="?">
                                    <i class="fas fa-home me-1"></i> Beranda
                                </a>
                            </li>
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md focus-color" href="?h=riwayat_peminjaman_aset">
                                    <i class="fas fa-history me-1"></i> Riwayat Peminjaman
                                </a>
                            </li>
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md focus-color" href="?h=riwayat_pengembalian_aset">
                                    <i class="fas fa-history me-1"></i> Riwayat Pengembalian
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md focus-color" href="?h=ganti_password">
                                <i class="fas fa-lock me-1"></i> Ganti Password
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md focus-color" href="halaman/logout/index.php">
                                <i class="fas fa-sign-out-alt me-1"></i> Keluar
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>