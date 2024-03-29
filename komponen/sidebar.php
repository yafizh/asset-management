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
            <!-- <li class="nav-item">
                <a class="nav-link <?= $active === 'dashboard' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=dashboard">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li> -->
            <?php if ($_SESSION['user']['status'] == 1) : ?>
                <!-- <li class="nav-item">
                    <a class="nav-link <?= $active === 'jenis_aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=jenis_aset">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">lan</i>
                        </div>
                        <span class="nav-link-text ms-1">Jenis Aset</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $active === 'kategori_aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=kategori_aset">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">real_estate_agent</i>
                        </div>
                        <span class="nav-link-text ms-1">Kategori Aset</span>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link <?= $active === 'pegawai' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=pegawai">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">group</i>
                        </div>
                        <span class="nav-link-text ms-1">Pegawai</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($_SESSION['user']['status'] == 1 || $_SESSION['user']['status'] == 2) : ?>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-8">Data Aset</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $active === 'aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=jenis_aset">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">select_all</i>
                        </div>
                        <span class="nav-link-text ms-1">Aset</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $active === 'aset_masuk' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=aset_masuk">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">dangerous</i>
                        </div>
                        <span class="nav-link-text ms-1">Penambahan Aset</span>
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
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-8">Peminjaman Aset</h6>
                </li>
                <?php
                $result = $mysqli->query("SELECT COUNT(*) as jumlah FROM peminjaman_aset WHERE status=1");
                $peminjaman_aset = $result->fetch_assoc();
                ?>
                <li class="nav-item">
                    <a class="nav-link <?= $active === 'pengajuan_peminjaman_aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=pengajuan_peminjaman_aset">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">today</i>
                        </div>
                        <span class="nav-link-text ms-1">Peminjaman Aset
                            <?php if ($peminjaman_aset['jumlah']) : ?>
                                <span class="badge text-bg-danger"><?= $peminjaman_aset['jumlah']; ?></span>
                            <?php endif; ?>
                        </span>
                    </a>
                </li>
                <?php
                $result = $mysqli->query("SELECT COUNT(*) as jumlah FROM pengembalian_aset WHERE status=1");
                $pengembalian_aset = $result->fetch_assoc();
                ?>
                <li class="nav-item">
                    <a class="nav-link <?= $active === 'pengajuan_pengembalian_aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=pengajuan_pengembalian_aset">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">today</i>
                        </div>
                        <span class="nav-link-text ms-1">Pengembalian Aset
                            <?php if ($pengembalian_aset['jumlah']) : ?>
                                <span class="badge text-bg-danger"><?= $pengembalian_aset['jumlah']; ?></span>
                            <?php endif; ?>
                        </span>
                    </a>
                </li>
            <?php endif; ?>
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
                <a class="nav-link <?= $active === 'laporan_aset_masuk' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=laporan_aset_masuk">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">today</i>
                    </div>
                    <span class="nav-link-text ms-1">Penambahan Aset</span>
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
                <a class="nav-link <?= $active === 'laporan_peminjaman_aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=laporan_peminjaman_aset">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">today</i>
                    </div>
                    <span class="nav-link-text ms-1">Peminjaman Aset</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active === 'laporan_pengembalian_aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=laporan_pengembalian_aset">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">today</i>
                    </div>
                    <span class="nav-link-text ms-1">Pengembalian Aset</span>
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
            <!-- <li class="nav-item">
                <a class="nav-link <?= $active === 'laporan_jumlah_aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=laporan_jumlah_aset">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">today</i>
                    </div>
                    <span class="nav-link-text ms-1">Jumlah Aset</span>
                </a>
            </li> -->
            <li class="nav-item mb-5">
                <a class="nav-link <?= $active === 'laporan_kondisi_aset' ? 'active bg-gradient-success text-white' : 'text-dark'; ?>" href="?h=laporan_kondisi_aset">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">today</i>
                    </div>
                    <span class="nav-link-text ms-1">Kondisi Aset</span>
                </a>
            </li>
        </ul>
    </div>
</aside>