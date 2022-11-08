<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Laporan Data Jumlah Aset</h6>
                        <a href="#" class="btn btn-dark m-0">Cetak</a>
                    </div>
                </div>
                <div class="card-body pb-3">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 small-td">No</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Jenis Aset</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Rusak</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Hilang</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Tersedia</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Total</th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                                SELECT 
                                    ja.id, 
                                    ja.nama, 
                                    (SELECT COUNT(a.id) FROM aset AS a WHERE a.id_jenis_aset=ja.id AND a.id IN (SELECT id_aset FROM aset_rusak)) AS rusak, 
                                    (SELECT COUNT(a.id) FROM aset AS a WHERE a.id_jenis_aset=ja.id AND a.id IN (SELECT id_aset FROM aset_hilang)) AS hilang, 
                                    (SELECT COUNT(a.id) FROM aset AS a WHERE a.id_jenis_aset=ja.id AND a.id IN (SELECT id_aset FROM pemeliharaan_aset AS plhra WHERE plhra.tanggal_selesai IS NULL)) AS sedang_pemeliharaan, 
                                    (SELECT COUNT(a.id) FROM aset AS a INNER JOIN peminjaman_aset AS pa ON a.id=pa.id_aset WHERE a.id_jenis_aset=ja.id AND pa.status BETWEEN 3 AND 5 AND a.id NOT IN (SELECT id_aset FROM aset_rusak UNION ALL SELECT id_aset FROM aset_hilang UNION ALL SELECT id_aset FROM pemeliharaan_aset WHERE tanggal_selesai IS NULL)) AS sedang_dipinjam, 
                                    (SELECT COUNT(a.id) FROM aset AS a LEFT JOIN peminjaman_aset AS pa ON a.id=pa.id_aset WHERE a.id_jenis_aset=ja.id AND ((SELECT (SELECT pa.status FROM peminjaman_aset AS pa WHERE pa.id_aset=a.id ORDER BY pa.id DESC LIMIT 1) IN (2,6)) OR pa.status IS NULL) AND a.id NOT IN (SELECT id_aset FROM aset_rusak UNION ALL SELECT id_aset FROM aset_hilang UNION ALL SELECT id_aset FROM pemeliharaan_aset WHERE tanggal_selesai IS NULL)) AS tersedia,
                                    (SELECT COUNT(a.id) FROM aset AS a WHERE a.id_jenis_aset=ja.id) AS total 
                                FROM 
                                    jenis_aset AS ja
                            ";
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
                                                <p class="text-secondary mb-0"><?= $row['nama']; ?></p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?= $row['rusak']; ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?= $row['hilang']; ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?= $row['tersedia'] + $row['sedang_pemeliharaan'] + $row['sedang_dipinjam']; ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?= $row['total']; ?>
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