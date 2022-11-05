<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Data Aset</h6>
                        <a href="?h=tambah_aset" class="btn btn-dark m-0">Tambah</a>
                    </div>
                </div>
                <div class="card-body pb-3">
                    <div class="table-responsive p-0">
                        <table id="datatable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 small-td">No</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Jenis Aset</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Rusak</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Hilang</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Sedang Pemeliharaan</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Dipesan</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Sedang Dipinjam</th>
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
                                    (SELECT COUNT(a.id) FROM aset AS a INNER JOIN peminjaman_aset AS pa ON a.id=pa.id_aset WHERE a.id_jenis_aset=ja.id AND pa.status BETWEEN 2 AND 5 AND a.id NOT IN (SELECT id_aset FROM aset_rusak UNION ALL SELECT id_aset FROM aset_hilang UNION ALL SELECT id_aset FROM pemeliharaan_aset WHERE tanggal_selesai IS NULL)) AS sedang_dipinjam, 
                                    (SELECT COUNT(a.id) FROM aset AS a INNER JOIN peminjaman_aset AS pa ON a.id=pa.id_aset WHERE a.id_jenis_aset=ja.id AND pa.status = 1 AND a.id NOT IN (SELECT id_aset FROM aset_rusak UNION ALL SELECT id_aset FROM aset_hilang UNION ALL SELECT id_aset FROM pemeliharaan_aset WHERE tanggal_selesai IS NULL)) AS dipesan,
                                    (SELECT COUNT(a.id) FROM aset AS a LEFT JOIN peminjaman_aset AS pa ON a.id=pa.id_aset WHERE a.id_jenis_aset=ja.id AND (pa.status NOT BETWEEN 1 AND 5 OR pa.status IS NULL) AND a.id NOT IN (SELECT id_aset FROM aset_rusak UNION ALL SELECT id_aset FROM aset_hilang UNION ALL SELECT id_aset FROM pemeliharaan_aset WHERE tanggal_selesai IS NULL)) AS tersedia,
                                    (SELECT COUNT(a.id) FROM aset AS a WHERE a.id_jenis_aset=ja.id) AS total 
                                FROM 
                                    jenis_aset AS ja
                            ";
                            $result = $mysqli->query($q);
                            $no = 1;
                            ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center">
                                            <p class="text-secondary mb-0"><?= $no++; ?></p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-secondary mb-0"><?= $row['nama']; ?></p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="?h=aset_rusak" class="btn btn-sm m-0 btn-danger text-white">
                                                <span class="badge badge-sm bg-gradient-danger p-2">
                                                    <?= $row['rusak']; ?>
                                                </span>
                                                Lihat
                                            </a>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="?h=aset_hilang" class="btn btn-sm m-0 btn-danger text-white">
                                                <span class="badge badge-sm bg-gradient-danger p-2">
                                                    <?= $row['hilang']; ?>
                                                </span>
                                                Lihat
                                            </a>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="?h=pemeliharaan_aset" class="btn btn-sm m-0 btn-warning text-white">
                                                <span class="badge badge-sm bg-gradient-warning p-2">
                                                    <?= $row['sedang_pemeliharaan']; ?>
                                                </span>
                                                Lihat
                                            </a>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="#" class="btn btn-sm m-0 btn-warning text-white">
                                                <span class="badge badge-sm bg-gradient-warning p-2">
                                                    <?= $row['dipesan']; ?>
                                                </span>
                                                Lihat
                                            </a>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="#" class="btn btn-sm m-0 btn-info text-white">
                                                <span class="badge badge-sm bg-gradient-info p-2">
                                                    <?= $row['sedang_dipinjam']; ?>
                                                </span>
                                                Lihat
                                            </a>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="?h=aset_per_jenis_aset&id=<?= $row['id'] ?>" class="btn btn-sm m-0 btn-success text-white">
                                                <span class="badge badge-sm bg-gradient-success p-2">
                                                    <?= $row['tersedia']; ?>
                                                </span>
                                                Lihat
                                            </a>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="?h=aset_per_jenis_aset&id=<?= $row['id'] ?>" class="btn btn-sm m-0 btn-info text-white">
                                                <span class="badge badge-sm bg-gradient-info p-2">
                                                    <?= $row['total']; ?>
                                                </span>
                                                Lihat
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>