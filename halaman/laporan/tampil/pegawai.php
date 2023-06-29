<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card my-4">
                <form action="" method="POST">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize m-0">Filter Laporan</h6>
                            <button type="submit" class="btn btn-dark m-0">Filter</button>
                        </div>
                    </div>
                    <div class="card-body pb-3">
                        <div class="mb-3">
                            <label class="form-label" for="dari_tanggal">Dari TMT (Terhitung Mulai Tanggal)</label>
                            <input type="date" class="form-control p-2" name="dari_tanggal" id="dari_tanggal" value="<?= $_POST['dari_tanggal'] ?? ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="sampai_tanggal">Sampai TMT (Terhitung Mulai Tanggal)</label>
                            <input type="date" class="form-control p-2" name="sampai_tanggal" id="sampai_tanggal" value="<?= $_POST['sampai_tanggal'] ?? ''; ?>">
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="status_pengguna">Status Pengguna</label>
                            <select name="status_pengguna" id="status_pengguna" class="form-control">
                                <option value="" selected>Semua Status Pengguna</option>
                                <option value="1" <?= (($_POST['status_pengguna'] ?? '') == 1 ? 'selected' : '') ?>>Admin</option>
                                <option value="2" <?= (($_POST['status_pengguna'] ?? '') == 2 ? 'selected' : '') ?>>Petugas</option>
                                <option value="3" <?= (($_POST['status_pengguna'] ?? '') == 3 ? 'selected' : '') ?>>Pegawai</option>
                                <option value="4" <?= (($_POST['status_pengguna'] ?? '') == 4 ? 'selected' : '') ?>>Kepala Balai</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Laporan Pegawai</h6>
                        <form action="halaman/laporan/cetak/index.php?h=pegawai" method="POST" target="_blank">
                            <input type="text" hidden name="dari_tanggal" value="<?= $_POST['dari_tanggal'] ?? ''; ?>">
                            <input type="text" hidden name="sampai_tanggal" value="<?= $_POST['sampai_tanggal'] ?? ''; ?>">
                            <input type="text" hidden name="status_pengguna" value="<?= $_POST['status_pengguna'] ?? ''; ?>">
                            <button type="submit" class="btn btn-dark m-0">Cetak</button>
                        </form>
                    </div>
                </div>
                <div class="card-body pb-3">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 small-td">No</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">TMT</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">NIP</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Jabatan</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Status Pengguna</th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                                SELECT
                                    pegawai.*,
                                    pengguna.status status_pengguna
                                FROM 
                                    pegawai 
                                INNER JOIN 
                                    pengguna 
                                ON 
                                    pengguna.id=pegawai.id_pengguna 
                                WHERE 
                                    1=1";

                            if (!empty($_POST['dari_tanggal'] ?? '') && !empty($_POST['sampai_tanggal'] ?? ''))
                                $q .= " AND (
                                        pegawai.tmt >= '" . $_POST['dari_tanggal'] . "' 
                                        AND 
                                        pegawai.tmt <= '" . $_POST['sampai_tanggal'] . "' 
                                    )";

                            if (!empty($_POST['status_pengguna'] ?? ''))
                                $q .= " AND pengguna.status = " . $_POST['status_pengguna'];

                            $q .= " ORDER BY pegawai.nama";

                            $result = $mysqli->query($q);
                            $no = 1;
                            ?>
                            <tbody>
                                <?php if ($result->num_rows) : ?>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= $no++; ?></p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= tanggalIndonesia($row['tmt']); ?></p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= $row['nip']; ?></p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= $row['nama']; ?></p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= $row['jabatan']; ?></p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0">
                                                    <?php if ($row['status_pengguna'] == 1) : ?>
                                                        Admin
                                                    <?php elseif ($row['status_pengguna'] == 2) : ?>
                                                        Petugas
                                                    <?php elseif ($row['status_pengguna'] == 3) : ?>
                                                        Pegawai
                                                    <?php elseif ($row['status_pengguna'] == 4) : ?>
                                                        Kepala Balai
                                                    <?php endif; ?>
                                                </p>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Data Kosong</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>