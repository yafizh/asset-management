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
                            <label class="form-label" for="dari_tanggal">Dari Tanggal</label>
                            <input type="date" class="form-control p-2" name="dari_tanggal" id="dari_tanggal" value="<?= $_POST['dari_tanggal'] ?? ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="sampai_tanggal">Sampai Tanggal</label>
                            <input type="date" class="form-control p-2" name="sampai_tanggal" id="sampai_tanggal" value="<?= $_POST['sampai_tanggal'] ?? ''; ?>">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-9">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Laporan Peminjaman Aset</h6>
                        <a target="_blank" href="?halaman/cetak/aset_rusak.php?dari_tanggal=<?= $_POST['dari_tanggal'] ?? ''; ?>&sampai_tanggal=<?= $_POST['sampai_tanggal'] ?? ''; ?>" class="btn btn-dark m-0">Cetak</a>
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
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Jenis Aset</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Nama Aset</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Tanggal Peminjaman</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Tanggal Selesai</th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                                SELECT
                                    DATE(pa.timestamp_pengajuan_ditentukan) AS tanggal_peminjaman,  
                                    DATE(pa.timestamp_pengajuan_ditentukan) AS tanggal_selesai,
                                    p.nip,
                                    p.nama,
                                    ja.nama AS jenis_aset,
                                    sa.nama AS sifat_aset,
                                    a.nama   
                                FROM 
                                    peminjaman_aset AS pa  
                                INNER JOIN 
                                    aset AS a
                                ON 
                                    a.id=pa.id_aset 
                                INNER JOIN 
                                    jenis_aset AS ja  
                                ON 
                                    ja.id=a.id_jenis_aset 
                                INNER JOIN 
                                    sifat_aset AS sa  
                                ON 
                                    sa.id=a.id_sifat_aset 
                                INNER JOIN 
                                    pegawai AS p  
                                ON 
                                    p.id=pa.id_pegawai 
                                WHERE 
                                    pa.status = 3 OR pa.status = 6 
                                ";

                            if (!empty($_POST['dari_tanggal'] ?? '') && !empty($_POST['sampai_tanggal'] ?? ''))
                                $q .= " AND DATE(pa.timestamp_pengajuan_ditentukan) >= '" . $_POST['dari_tanggal'] . "' AND DATE(pa.timestamp_pengajuan_ditentukan) <= '" . $_POST['sampai_tanggal'] . "'";

                            $q .= " ORDER BY pa.timestamp_pengajuan_ditentukan DESC";
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
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= $row['nama']; ?></p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= $row['jenis_aset']; ?></p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= $row['nama']; ?></p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= $row['tanggal_peminjaman']; ?></p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= is_null($row['tanggal_selesai']) ? "Belum Dikembalikan" : $row['tanggal_selesai']; ?></p>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Data Kosong</td>
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