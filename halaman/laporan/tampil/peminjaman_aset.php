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
                            <label class="form-label" for="dari_tanggal">Dari Tanggal</label>
                            <input type="date" class="form-control p-2" name="dari_tanggal" id="dari_tanggal" value="<?= $_POST['dari_tanggal'] ?? ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="sampai_tanggal">Sampai Tanggal</label>
                            <input type="date" class="form-control p-2" name="sampai_tanggal" id="sampai_tanggal" value="<?= $_POST['sampai_tanggal'] ?? ''; ?>" required>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <?php $result = $mysqli->query("SELECT * FROM pegawai WHERE id_pengguna IN (SELECT id FROM pengguna WHERE status=2)"); ?>
                            <label for="id_pengguna">Petugas Yang Memverifikasi</label>
                            <select name="id_pengguna" id="id_pengguna" class="form-control">
                                <option value="" selected>Semua Petugas</option>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <option value="<?= $row['id_pengguna']; ?>" <?= (($_POST['id_pengguna'] ?? '') == $row['id_pengguna'] ? 'selected' : '') ?>><?= $row['nama']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php if (isset($_POST['dari_tanggal'])) : ?>
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize m-0">Laporan Peminjaman Aset</h6>
                            <form action="halaman/laporan/cetak/index.php?h=peminjaman_aset" method="POST" target="_blank">
                                <input type="text" hidden name="dari_tanggal" value="<?= $_POST['dari_tanggal'] ?? ''; ?>">
                                <input type="text" hidden name="sampai_tanggal" value="<?= $_POST['sampai_tanggal'] ?? ''; ?>">
                                <input type="text" hidden name="id_pengguna" value="<?= $_POST['id_pengguna'] ?? ''; ?>">
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
                                        <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Tanggal</th>
                                        <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">NIP</th>
                                        <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Nama Pegawai</th>
                                        <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Nama Aset</th>
                                        <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Jumlah</th>
                                    </tr>
                                </thead>
                                <?php
                                $q = "
                                SELECT
                                    pegawai.nip nip_pegawai,
                                    pegawai.nama nama_pegawai,
                                    a.nama nama_aset, 
                                    DATE(pa.tanggal_waktu_pengajuan) tanggal,
                                    pa.jumlah 
                                FROM 
                                    peminjaman_aset pa   
                                INNER JOIN 
                                    aset a
                                ON 
                                    a.id=pa.id_aset 
                                INNER JOIN 
                                    pengguna 
                                ON 
                                    pengguna.id=pa.id_user_peminjam 
                                LEFT JOIN 
                                    pegawai 
                                ON 
                                    pegawai.id_pengguna=pengguna.id 
                                WHERE 
                                    (
                                        DATE(pa.tanggal_waktu_pengajuan) >= '" . $_POST['dari_tanggal'] . "' 
                                        AND 
                                        DATE(pa.tanggal_waktu_pengajuan) <= '" . $_POST['sampai_tanggal'] . "' 
                                    ) ";

                                if (!empty($_POST['id_pengguna'] ?? ''))
                                    $q .= " AND id_user_verifikator = " . $_POST['id_pengguna'];

                                $q .= " ORDER BY pa.tanggal_waktu_pengajuan DESC";

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
                                                    <p class="text-secondary mb-0"><?= tanggalIndonesia($row['tanggal']); ?></p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-secondary mb-0"><?= $row['nip_pegawai']; ?></p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-secondary mb-0"><?= $row['nama_pegawai']; ?></p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-secondary mb-0"><?= $row['nama_aset']; ?></p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-secondary mb-0"><?= $row['jumlah']; ?></p>
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
        <?php endif; ?>
    </div>
</div>