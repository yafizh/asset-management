<div class="container-fluid py-4">
    <div class="row mb-3">
        <div class="col-12 text-center">
            <h2>Scan QR CODE Untuk Menemukan Aset</h2>
            <a href="?h=pengajuan_peminjaman" class="btn btn-lg btn-success">SCAN QR CODE ASET</a>
            <h3>Atau Lakukan Pencarian Manual Berdasarkan Jenis Aset</h3>
        </div>
    </div>
    <?php
    $q = "
        SELECT 
            kategori_aset.id,
            kategori_aset.nama, 
            (SELECT COUNT(id) FROM aset WHERE aset.id_kategori_aset=kategori_aset.id AND nama LIKE '%" . ($_POST['keyword'] ?? '') . "%') AS count
        FROM 
            kategori_aset";
    $result_kategori_aset = $mysqli->query($q);
    ?>
    <?php while ($kategori_aset = $result_kategori_aset->fetch_assoc()) : ?>
        <?php if (!$kategori_aset['count']) : ?>
            <?php continue; ?>
        <?php endif; ?>
        <div class="row mb-3">
            <div class="col-12">
                <h2><?= $kategori_aset['nama']; ?></h3>
            </div>
        </div>
        <?php
        $q = "
            SELECT 
                a.id,
                a.nama,  
                a.foto, 
                a.status 
            FROM 
                aset AS a 
            WHERE 
                id_kategori_aset=" . $kategori_aset['id'] . "
        ";
        if (isset($_POST['keyword']))
            $q .= " AND a.nama LIKE '%" . $_POST['keyword'] . "%'";

        $q .= " ORDER BY status";
        $result_aset = $mysqli->query($q);
        ?>
        <div class="row mb-5">
            <?php if ($result_aset->num_rows) : ?>
                <?php while ($aset = $result_aset->fetch_assoc()) : ?>
                    <?php $aset['detail'] = $mysqli->query("SELECT * FROM detail_aset WHERE id_aset=" . $aset['id'])->fetch_all(MYSQLI_ASSOC); ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <?php if ($aset['status'] == 1) : ?>
                                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                                        <h6 class="text-white text-capitalize m-0" style="flex: 1;">Tersedia</h6>
                                        <button type="button" class="btn btn-dark m-0" data-bs-toggle="modal" data-bs-target="#detailModal<?= $aset['id']; ?>">Lihat</button>
                                    </div>
                                <?php elseif ($aset['status'] == 2) : ?>
                                    <div class="bg-gradient-danger shadow-danger border-radius-lg p-3 d-flex justify-content-between align-items-center">
                                        <h6 class="text-white text-capitalize m-0" style="flex: 1;">Rusak</h6>
                                        <button type="button" class="btn btn-dark m-0" data-bs-toggle="modal" data-bs-target="#detailModal<?= $aset['id']; ?>">Lihat</button>
                                    </div>
                                <?php elseif ($aset['status'] == 3) : ?>
                                    <div class="bg-gradient-danger shadow-danger border-radius-lg p-3 d-flex justify-content-between align-items-center">
                                        <h6 class="text-white text-capitalize m-0" style="flex: 1;">Hilang</h6>
                                        <button type="button" class="btn btn-dark m-0" data-bs-toggle="modal" data-bs-target="#detailModal<?= $aset['id']; ?>">Lihat</button>
                                    </div>
                                <?php elseif ($aset['status'] == 4) : ?>
                                    <div class="bg-gradient-warning shadow-warning border-radius-lg p-3 d-flex justify-content-between align-items-center">
                                        <h6 class="text-white text-capitalize m-0" style="flex: 1;">Sedang Pemeliharan</h6>
                                        <button type="button" class="btn btn-dark m-0" data-bs-toggle="modal" data-bs-target="#detailModal<?= $aset['id']; ?>">Lihat</button>
                                    </div>
                                <?php elseif ($aset['status'] == 5) : ?>
                                    <div class="bg-gradient-info shadow-info border-radius-lg p-3 d-flex justify-content-between align-items-center">
                                        <h6 class="text-white text-capitalize m-0" style="flex: 1;">Sedang Dipinjam</h6>
                                        <button type="button" class="btn btn-dark m-0" data-bs-toggle="modal" data-bs-target="#detailModal<?= $aset['id']; ?>">Lihat</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body p-2">
                                <img src="<?= $aset['foto']; ?>" style="width: 100%; aspect-ratio: 1/1; object-fit: cover;" class="border rounded">
                            </div>
                        </div>
                        <!-- Detail Modal -->
                        <div class="modal fade" id="detailModal<?= $aset['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="detailModal<?= $aset['id']; ?>Label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title font-weight-normal" id="detailModal<?= $aset['id']; ?>Label"><?= $aset['nama']; ?></h5>
                                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="<?= $aset['foto']; ?>" style="width: 100%; height: 15rem; object-fit: cover;" class="border rounded mb-3">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th colspan="2">Detail</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($aset['detail'] as $key => $value) : ?>
                                                    <tr>
                                                        <td><?= $value['kolom']; ?></td>
                                                        <td><?= $value['nilai']; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <?php if ($aset['status'] == 1) : ?>
                                                    <tr class="text-white text-center" style="overflow: hidden;">
                                                        <td class="bg-gradient-success" colspan="2">Tersedia</td>
                                                    </tr>
                                                <?php elseif ($aset['status'] == 2) : ?>
                                                    <tr class="text-white text-center" style="overflow: hidden;">
                                                        <td class="bg-gradient-danger" colspan="2">Rusak</td>
                                                    </tr>
                                                <?php elseif ($aset['status'] == 3) : ?>
                                                    <tr class="text-white text-center" style="overflow: hidden;">
                                                        <td class="bg-gradient-danger" colspan="2">Hilang</td>
                                                    </tr>
                                                <?php elseif ($aset['status'] == 4) : ?>
                                                    <tr class="text-white text-center" style="overflow: hidden;">
                                                        <td class="bg-gradient-warning" colspan="2">Sedang Pemeliharaan</td>
                                                    </tr>
                                                <?php elseif ($aset['status'] == 5) : ?>
                                                    <tr class="bg-gradient-info text-white text-center" style="overflow: hidden;">
                                                        <td class="bg-gradient-info" colspan="2">Sedang Dipinjam</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php if ($aset['status'] == 1) : ?>
                                        <div class="modal-footer justify-content-center">
                                            <a href="?h=pengajuan_peminjaman&id=<?= $aset['id']; ?>" class="btn bg-gradient-success">Ajukan Peminjaman</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- End Detail Modal -->
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <h5 class="text-muted text-center">Aset <?= $kategori_aset['nama']; ?> Tidak Tersedia</h5>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>