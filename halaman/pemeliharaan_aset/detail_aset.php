<?php
$q = "
    SELECT 
        ja.nama jenis_aset,
        sa.nama kategori_aset,
        a.id_kategori_aset,
        a.nama,
        a.foto,
        pa.id,
        pa.tanggal_mulai,
        pa.tanggal_selesai,
        pa.keterangan keterangan_pemeliharaan 
    FROM 
        pemeliharaan_aset pa 
    INNER JOIN 
        aset a 
    ON 
        pa.id_aset=a.id 
    INNER JOIN 
        jenis_aset ja 
    ON 
        ja.id=a.id_jenis_aset 
    INNER JOIN 
        kategori_aset sa 
    ON 
        sa.id=a.id_kategori_aset   
    WHERE 
        pa.id=" . $_GET['id'];
$result = $mysqli->query($q);
$data = $result->fetch_assoc();
$data['detail'] = $mysqli->query("SELECT * FROM detail_aset WHERE id_aset=" . $_GET['id'])->fetch_all(MYSQLI_ASSOC);
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
                                <input type="text" class="form-control p-2" disabled value="<?= $data['kategori_aset'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['nama'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Detail</label>
                                <?php foreach ($data['detail'] as $key => $value) : ?>
                                    <div class="row ps-1 mb-2">
                                        <div class="col-auto" style="width: 120px;"><?= $value['kolom']; ?></div>
                                        <div class="col-8">: <?= $value['nilai']; ?></div>
                                    </div>
                                <?php endforeach; ?>
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
                                <a href="?h=aset_selesai_pemeliharaan&id=<?= $data['id_kategori_aset']; ?>" class="btn btn-secondary">Kembali</a>
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