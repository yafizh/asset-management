<?php
$q = "
    SELECT 
        ja.nama AS jenis_aset,
        sa.nama AS sifat_aset,
        a.id_jenis_aset,
        a.nama,
        a.detail,
        a.foto,
        pa.id,
        pa.tanggal_mulai,
        pa.tanggal_selesai,
        pa.keterangan AS keterangan_pemeliharaan 
    FROM 
        pemeliharaan_aset AS pa 
    INNER JOIN 
        aset AS a 
    ON 
        pa.id_aset=a.id 
    INNER JOIN 
        jenis_aset AS ja 
    ON 
        ja.id=a.id_jenis_aset 
    INNER JOIN 
        sifat_aset AS sa 
    ON 
        sa.id=a.id_sifat_aset   
    WHERE 
        pa.id=" . $_GET['id'];
$result = $mysqli->query($q);
$data = $result->fetch_assoc();
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="col-12 mb-5">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize m-0">Gambar Aset</h6>
                            <button class="btn btn-dark m-0" data-bs-toggle="modal" data-bs-target="#detailGambarModal">Lihat</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <img src="<?= $data['foto']; ?>" class="rounded" style="width: 100%; aspect-ratio: 16 / 9; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Detail Aset Rusak</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Jenis Aset</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['jenis_aset'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sifat Aset</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['sifat_aset'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['nama'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_masuk" class="form-label">Detail</label>
                                <div class="row" id="detail">
                                    <?php foreach (json_decode($data['detail']) as $key => $value) : ?>
                                        <div class="col-6 mb-3">
                                            <input type="text" class="form-control p-2" value="<?= $key; ?>" disabled>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <input type="text" class="form-control p-2" value="<?= $value; ?>" disabled>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai Pemeliharaan</label>
                                <input type="text" class="form-control p-2" disabled value="<?= tanggalIndonesiaString($data['tanggal_mulai']); ?>">
                            </div>
                            <?php if (!is_null($data['tanggal_selesai'])) : ?>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Selesai Pemeliharaan</label>
                                    <input type="text" class="form-control p-2" disabled value="<?= tanggalIndonesiaString($data['tanggal_selesai']); ?>">
                                </div>
                            <?php endif; ?>
                            <div class="mb-3">
                                <label class="form-label">Keterangan Pemeliharaan</label>
                                <textarea class="form-control p-2" rows="5" disabled><?= $data['keterangan_pemeliharaan'] ?></textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="?h=aset_selesai_pemeliharaan&id=<?= $data['id_jenis_aset']; ?>" class="btn btn-secondary">Kembali</a>
                                <?php if (is_null($data['tanggal_selesai'])) : ?>
                                    <a href="?h=pemeliharaan_aset_selesai&id=<?= $data['id']; ?>" class="btn btn-success" onclick="return confirm('Yakin?')">Pemeliharaan Selesai</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade animate__animated animate__zoomIn" id="detailGambarModal" tabindex="-1" aria-labelledby="detailGambarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-0">
                <img src="<?= $data['foto']; ?>" style="width: 100%; object-fit: cover;">
            </div>
        </div>
    </div>
</div>