<div class="container-fluid py-4">
    <div class="row">
        <div class="col-3">
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
                            <label class="form-label" for="dari_tmt">Dari TMT</label>
                            <input type="date" class="form-control p-2" name="dari_tmt" id="dari_tmt" value="<?= $_POST['dari_tmt'] ?? ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="sampai_tmt">Sampai TMT</label>
                            <input type="date" class="form-control p-2" name="sampai_tmt" id="sampai_tmt" value="<?= $_POST['sampai_tmt'] ?? ''; ?>">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-9">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Laporan Pegawai</h6>
                        <a target="_blank" href="?halaman/cetak/pegawai.php?dari_tmt=<?= $_POST['dari_tmt'] ?? ''; ?>&sampai_tmt=<?= $_POST['sampai_tmt'] ?? ''; ?>" class="btn btn-dark m-0">Cetak</a>
                    </div>
                </div>
                <div class="card-body pb-3">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 small-td">No</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">NIP</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Jabatan</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">TMT</th>
                                </tr>
                            </thead>
                            <?php
                            $q = "SELECT * FROM pegawai";

                            if (!empty($_POST['dari_tmt'] ?? '') && !empty($_POST['sampai_tmt'] ?? ''))
                                $q .= " WHERE tmt >= '" . $_POST['dari_tmt'] . "' AND tmt <= '" . $_POST['sampai_tmt'] . "'";

                            $q .= " ORDER BY id DESC";
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
                                                <p class="text-secondary mb-0"><?= $row['nip']; ?></p>
                                            </td>
                                            <td class="">
                                                <p class="text-secondary mb-0"><?= $row['nama']; ?></p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= $row['jabatan']; ?></p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= tanggalIndonesia($row['tmt']); ?></p>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Data Kosong</td>
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