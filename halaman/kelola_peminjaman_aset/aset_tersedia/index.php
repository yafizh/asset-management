<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Data Aset Tersedia</h6>
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
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Jumlah Tersedia</th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                                SELECT 
                                    ja.id, 
                                    ja.nama, 
                                    (
                                        SELECT 
                                            COUNT(a.id) 
                                        FROM 
                                            aset AS a 
                                        LEFT JOIN 
                                            peminjaman_aset AS pa 
                                        ON 
                                            a.id=pa.id_aset 
                                        WHERE 
                                            a.id_jenis_aset=ja.id 
                                            AND 
                                            (pa.status = 2 OR pa.status = 6 OR pa.status IS NULL) 
                                            AND 
                                            a.id NOT IN (
                                                SELECT 
                                                    id_aset 
                                                FROM 
                                                    aset_rusak 
                                                UNION ALL 
                                                SELECT 
                                                    id_aset 
                                                FROM 
                                                    aset_hilang 
                                                UNION ALL 
                                                SELECT 
                                                    id_aset 
                                                FROM 
                                                    pemeliharaan_aset 
                                                WHERE 
                                                    tanggal_selesai IS NULL
                                                )
                                    ) AS tersedia 
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
                                        <td class="text-center">
                                            <p class="text-secondary mb-0"><?= $row['tersedia']; ?></p>
                                        </td>
                                        <td class="small-td">
                                            <a href="?h=aset_tersedia_per_jenis_aset&id=<?= $row['id']; ?>" class="btn btn-sm btn-info text-white">Lihat</a>
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