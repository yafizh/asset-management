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
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Kategori Aset</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Jumlah Tersedia</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7"></th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                                SELECT 
                                    *,
                                    (SELECT COUNT(*) FROM aset WHERE aset.id_kategori_aset=ka.id AND aset.status=1) tersedia
                                FROM 
                                    kategori_aset ka";
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
                                            <a href="?h=aset_tersedia_per_kategori_aset&id=<?= $row['id']; ?>" class="btn btn-sm btn-info text-white">Lihat</a>
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