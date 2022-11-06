<div class="container-fluid py-4">
    <div class="row pe-4 w-100 position-fixed bottom-0" style="z-index: 999;">
        <div class="col-12">
            <div class="row">
                <a href="?h=pengajuan_peminjaman" class="btn btn-lg btn-success">SCAN QR CODE ASET</a>
            </div>
        </div>
    </div>
    <?php
    $q = "SELECT * FROM jenis_aset";
    $result_jenis_aset = $mysqli->query($q);
    ?>
    <?php while ($jenis_aset = $result_jenis_aset->fetch_assoc()) : ?>
        <div class="row mb-3">
            <div class="col-12">
                <h2><?= $jenis_aset['nama']; ?></h3>
            </div>
        </div>
        <?php
        $q = "
            SELECT 
                a.id,
                a.nama,  
                a.keterangan, 
                a.detail, 
                a.foto, 
                IFNULL(
                    (SELECT ar.id FROM aset_rusak AS ar WHERE (ar.id_aset=a.id)), 
                    FALSE 
                ) AS rusak,
                IFNULL(
                    (SELECT ah.id FROM aset_hilang AS ah WHERE (ah.id_aset=a.id)), 
                    FALSE 
                ) AS hilang, 
                IFNULL(
                    (SELECT plhra.id FROM pemeliharaan_aset AS plhra WHERE plhra.id_aset=a.id AND plhra.tanggal_selesai IS NULL),
                    FALSE 
                ) AS sedang_pemeliharaan,
                IF(
                    (SELECT pa.status FROM peminjaman_aset AS pa WHERE (pa.id_aset=a.id) ORDER BY pa.id DESC LIMIT 1) = 1, 
                    TRUE,
                    FALSE
                ) AS sedang_dipesan,
                IF(
                    (SELECT pa.status FROM peminjaman_aset AS pa WHERE (pa.id_aset=a.id) ORDER BY pa.id DESC LIMIT 1) NOT IN (2,6),
                    TRUE, 
                    FALSE 
                ) AS sedang_dipinjam 
            FROM 
                aset AS a 
            WHERE 
                id_jenis_aset=" . $jenis_aset['id'] . "
        ";
        $result_aset = $mysqli->query($q);
        ?>
        <div class="row mb-5">
            <?php if ($result_aset->num_rows) : ?>
                <?php while ($aset = $result_aset->fetch_assoc()) : ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <?php if ($aset['rusak']) : ?>
                                    <div class="bg-gradient-danger shadow-danger border-radius-lg p-3 d-flex justify-content-between align-items-center">
                                        <h6 class="text-white text-capitalize m-0" style="flex: 1;">Rusak</h6>
                                        <button type="button" class="btn btn-dark m-0" data-bs-toggle="modal" data-bs-target="#detailModal<?= $aset['id']; ?>">Lihat</button>
                                    </div>
                                <?php elseif ($aset['hilang']) : ?>
                                    <div class="bg-gradient-danger shadow-danger border-radius-lg p-3 d-flex justify-content-between align-items-center">
                                        <h6 class="text-white text-capitalize m-0" style="flex: 1;">Hilang</h6>
                                        <button type="button" class="btn btn-dark m-0" data-bs-toggle="modal" data-bs-target="#detailModal<?= $aset['id']; ?>">Lihat</button>
                                    </div>
                                <?php elseif ($aset['sedang_pemeliharaan']) : ?>
                                    <div class="bg-gradient-warning shadow-warning border-radius-lg p-3 d-flex justify-content-between align-items-center">
                                        <h6 class="text-white text-capitalize m-0" style="flex: 1;">Sedang Pemeliharan</h6>
                                        <button type="button" class="btn btn-dark m-0" data-bs-toggle="modal" data-bs-target="#detailModal<?= $aset['id']; ?>">Lihat</button>
                                    </div>
                                <?php elseif ($aset['sedang_dipesan']) : ?>
                                    <div class="bg-gradient-warning shadow-warning border-radius-lg p-3 d-flex justify-content-between align-items-center">
                                        <h6 class="text-white text-capitalize m-0" style="flex: 1;">Sedang Diajukan Pegawai Lain</h6>
                                        <button type="button" class="btn btn-dark m-0" data-bs-toggle="modal" data-bs-target="#detailModal<?= $aset['id']; ?>">Lihat</button>
                                    </div>
                                <?php elseif ($aset['sedang_dipinjam']) : ?>
                                    <div class="bg-gradient-info shadow-info border-radius-lg p-3 d-flex justify-content-between align-items-center">
                                        <h6 class="text-white text-capitalize m-0" style="flex: 1;">Sedang Dipinjam</h6>
                                        <button type="button" class="btn btn-dark m-0" data-bs-toggle="modal" data-bs-target="#detailModal<?= $aset['id']; ?>">Lihat</button>
                                    </div>
                                <?php else : ?>
                                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                                        <h6 class="text-white text-capitalize m-0" style="flex: 1;">Tersedia</h6>
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
                                                <?php foreach (json_decode($aset['detail']) as $key => $value) : ?>
                                                    <tr>
                                                        <td><?= $key; ?></td>
                                                        <td><?= $value; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <?php if ($aset['rusak']) : ?>
                                                    <tr class="text-white text-center" style="overflow: hidden;">
                                                        <td class="bg-gradient-danger" colspan="2">Rusak</td>
                                                    </tr>
                                                <?php elseif ($aset['hilang']) : ?>
                                                    <tr class="text-white text-center" style="overflow: hidden;">
                                                        <td class="bg-gradient-danger" colspan="2">Hilang</td>
                                                    </tr>
                                                <?php elseif ($aset['sedang_pemeliharaan']) : ?>
                                                    <tr class="text-white text-center" style="overflow: hidden;">
                                                        <td class="bg-gradient-warning" colspan="2">Sedang Pemeliharaan</td>
                                                    </tr>
                                                <?php elseif ($aset['sedang_dipesan']) : ?>
                                                    <tr class="text-white text-center" style="overflow: hidden;">
                                                        <td class="bg-gradient-warning" colspan="2">Sedang Diajukan Pegawai Lain</td>
                                                    </tr>
                                                <?php elseif ($aset['sedang_dipinjam']) : ?>
                                                    <tr class="bg-gradient-info text-white text-center" style="overflow: hidden;">
                                                        <td class="bg-gradient-info" colspan="2">Sedang Dipinjam</td>
                                                    </tr>
                                                <?php else : ?>
                                                    <tr class="text-white text-center" style="overflow: hidden;">
                                                        <td class="bg-gradient-success" colspan="2">Tersedia</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php if (!$aset['rusak'] && !$aset['hilang'] && !$aset['sedang_pemeliharaan'] && !$aset['sedang_dipesan'] && !$aset['sedang_dipinjam']) : ?>
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
                <h5 class="text-muted text-center">Aset <?= $jenis_aset['nama']; ?> Tidak Tersedia</h5>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>