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
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Jenis Aset</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Jumlah</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Sedang Dipinjam</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                                SELECT 
                                    ja.nama AS jenis_aset, 
                                    COUNT(a.id) AS jumlah,
                                    (SELECT COUNT(id) FROM peminjaman_aset AS pa WHERE (pa.id_aset=a.id) AND (pa.timestamp_pengembalian_disetujui IS NULL)) AS sedang_dipinjam
                                FROM 
                                    aset AS a 
                                INNER JOIN 
                                    jenis_aset AS ja 
                                ON 
                                    a.id_jenis_aset=ja.id 
                                GROUP BY 
                                    id_jenis_aset
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
                                            <p class="text-secondary mb-0"><?= $row['jenis_aset']; ?></p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge badge-sm bg-gradient-success p-2"><?= $row['jumlah']; ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge badge-sm bg-gradient-info p-2"><?= $row['sedang_dipinjam']; ?></span>
                                        </td>
                                        <td class="small-td">
                                            <a href="?h=detail_aset&id=" class="btn btn-sm btn-info text-white">Lihat</a>
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