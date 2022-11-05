<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Data Aset Rusak</h6>
                    </div>
                </div>
                <div class="card-body pb-3">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 small-td">No</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Jenis Aset</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Jumlah Rusak</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                                SELECT 
                                    ja.id, 
                                    ja.nama, 
                                    (SELECT COUNT(a.id) FROM aset AS a INNER JOIN aset_rusak AS ar ON a.id=ar.id_aset WHERE ja.id=a.id_jenis_aset) AS rusak 
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
                                            <p class="text-secondary mb-0"><?= $row['rusak']; ?></p>
                                        </td>
                                        <td class="small-td">
                                            <a href="?h=aset_rusak_per_jenis_aset&id=<?= $row['id']; ?>" class="btn btn-sm btn-info text-white">Lihat</a>
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