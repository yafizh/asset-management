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
                <a class="nav-link <?= $active === 'dashboard' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=dashboard">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <?php if ($_SESSION['user']['status'] === 'admin') : ?>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-8">Data Master</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $active === 'jenis_aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=jenis_aset">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">lan</i>
                        </div>
                        <span class="nav-link-text ms-1">Jenis Aset</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $active === 'sifat_aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=sifat_aset">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">real_estate_agent</i>
                        </div>
                        <span class="nav-link-text ms-1">Sifat Aset</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $active === 'pegawai' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=pegawai">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">group</i>
                        </div>
                        <span class="nav-link-text ms-1">Pegawai</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $active === 'pengguna' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=pengguna">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <span class="nav-link-text ms-1">Pengguna</span>
                    </a>
                </li>
            <?php endif; ?>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-8">Data Aset</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active === 'aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=aset">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">select_all</i>
                    </div>
                    <span class="nav-link-text ms-1">Aset</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active === 'aset_rusak' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=aset_rusak">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dangerous</i>
                    </div>
                    <span class="nav-link-text ms-1">Aset Rusak</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active === 'aset_hilang' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=aset_hilang">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">view_in_ar</i>
                    </div>
                    <span class="nav-link-text ms-1">Aset Hilang</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active === 'pemeliharaan_aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=pemeliharaan_aset">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">date_range</i>
                    </div>
                    <span class="nav-link-text ms-1">Pemeliharaan Aset</span>
                </a>
            </li>
            <!-- <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-8">Peminjaman Aset</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active === 'aset_tersedia' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=aset_tersedia">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">event_available</i>
                    </div>
                    <span class="nav-link-text ms-1">Tersedia</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active === 'aset_dipinjam' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=aset_dipinjam">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">event</i>
                    </div>
                    <span class="nav-link-text ms-1">Dipinjam</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active === 'pengajuan_peminjaman_aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=pengajuan_peminjaman_aset">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">today</i>
                    </div>
                    <span class="nav-link-text ms-1">Pengajuan Peminjaman</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active === 'pengajuan_pengembalian_aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=pengajuan_pengembalian_aset">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">today</i>
                    </div>
                    <span class="nav-link-text ms-1">Pengajuan Pengembalian</span>
                </a>
            </li> -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-8">Laporan</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active === 'laporan_aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=laporan_aset">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">today</i>
                    </div>
                    <span class="nav-link-text ms-1">Aset</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active === 'laporan_aset_rusak' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=laporan_aset_rusak">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">today</i>
                    </div>
                    <span class="nav-link-text ms-1">Aset Rusak</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active === 'laporan_aset_hilang' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=laporan_aset_hilang">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">today</i>
                    </div>
                    <span class="nav-link-text ms-1">Aset Hilang</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active === 'laporan_pemeliharaan_aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=laporan_pemeliharaan_aset">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">today</i>
                    </div>
                    <span class="nav-link-text ms-1">Pemeliharaan Aset</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active === 'laporan_peminjaman_aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=laporan_peminjaman_aset">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">today</i>
                    </div>
                    <span class="nav-link-text ms-1">Peminjaman Aset</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active === 'laporan_grafik_peminjaman_aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=laporan_grafik_peminjaman_aset">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">today</i>
                    </div>
                    <span class="nav-link-text ms-1">Grafik Peminjaman Aset</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active === 'laporan_jumlah_aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=laporan_jumlah_aset">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">today</i>
                    </div>
                    <span class="nav-link-text ms-1">Jumlah Aset</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active === 'laporan_pegawai' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=laporan_pegawai">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">today</i>
                    </div>
                    <span class="nav-link-text ms-1">Pegawai</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-8">Pengaturan</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active === 'ganti_password' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=ganti_password">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">lock</i>
                    </div>
                    <span class="nav-link-text ms-1">Ganti Password</span>
                </a>
            </li>
            <li class="nav-item mb-5">
                <a class="nav-link text-dark" href="halaman/logout/index.php">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">login</i>
                    </div>
                    <span class="nav-link-text ms-1">Keluar</span>
                </a>
            </li>
        </ul>
    </div>
</aside>