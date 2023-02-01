<?php
$q = "
    SELECT 
        ka.nama kategori_aset,
        pa.id,
        a.nama,
        a.id id_aset,
        a.foto,
        DATE(pa.timestamp_pengajuan) tanggal_pengajuan,
        DATE(pa.timestamp_pengembalian) tanggal_pengembalian,
        DATE(pa.timestamp_pengajuan_ditentukan) tanggal_pengajuan_ditentukan,
        DATE(pa.timestamp_pengembalian_ditentukan) tanggal_pengembalian_ditentukan,
        pa.keterangan_pengajuan,
        pa.keterangan_pengembalian,
        pa.alasan_peminjaman,
        pa.alasan_pengembalian,
        pa.status
    FROM 
        peminjaman_aset pa  
    INNER JOIN 
        aset a 
    ON 
        a.id=pa.id_aset
    INNER JOIN 
        kategori_aset ka 
    ON 
        ka.id=a.id_kategori_aset  
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
                        <h6 class="text-white text-capitalize m-0">Detail Aset</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
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
                                <label class="form-label">Tanggal Pengajuan</label>
                                <input type="text" class="form-control p-2" disabled value="<?= tanggalIndonesiaString($data['tanggal_pengajuan']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label d-block">Status Pengajuan</label>
                                <?php if ($data['status'] == 1) : ?>
                                    <span class="badge bg-gradient-info">Menunggu Persetujuan</span>
                                <?php elseif ($data['status'] == 2) : ?>
                                    <span class="badge bg-gradient-danger">Pengajuan Ditolak</span>
                                <?php elseif ($data['status'] >= 3) : ?>
                                    <span class="badge bg-gradient-success">Pengajuan Diterima</span>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alasan Peminjaman</label>
                                <textarea class="form-control p-2" rows="5" disabled><?= $data['alasan_peminjaman'] ?></textarea>
                            </div>
                            <?php if ($data['status'] != 1) : ?>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Pengajuan <?= $data['status'] == 2 ? 'Ditolak' : 'Diterima';  ?></label>
                                    <input type="text" class="form-control p-2" disabled value="<?= tanggalIndonesiaString($data['tanggal_pengajuan_ditentukan']); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Keterangan Pengajuan <?= $data['status'] == 2 ? 'Ditolak' : 'Diterima';  ?></label>
                                    <textarea class="form-control p-2" rows="5" disabled><?= $data['keterangan_pengajuan'] ?></textarea>
                                </div>
                            <?php endif; ?>
                            <?php if ($data['status'] >= 4) : ?>
                                <hr>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Pengajuan Pengembalian</label>
                                    <input type="text" class="form-control p-2" disabled value="<?= tanggalIndonesiaString($data['tanggal_pengembalian']); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label d-block">Status Pengajuan</label>
                                    <?php if ($data['status'] == 4) : ?>
                                        <span class="badge bg-gradient-info">Menunggu Persetujuan</span>
                                    <?php elseif ($data['status'] == 5) : ?>
                                        <span class="badge bg-gradient-danger">Pengajuan Pengembalian Ditolak</span>
                                    <?php elseif ($data['status'] == 6) : ?>
                                        <span class="badge bg-gradient-success">Pengajuan Pengembalian Diterima</span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($data['status'] > 4) : ?>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Pengajuan Pengembalian <?= $data['status'] == 5 ? 'Ditolak' : 'Diterima';  ?></label>
                                    <input type="text" class="form-control p-2" disabled value="<?= tanggalIndonesiaString($data['tanggal_pengembalian_ditentukan']); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Keterangan Pengajuan Pengembalian <?= $data['status'] == 5 ? 'Ditolak' : 'Diterima';  ?></label>
                                    <textarea class="form-control p-2" rows="5" disabled><?= $data['keterangan_pengembalian'] ?></textarea>
                                </div>
                            <?php endif; ?>
                            <div class="d-flex justify-content-between">
                                <a href="?h=riwayat_peminjaman_aset" class="btn btn-secondary">Kembali</a>
                                <?php if ($data['status'] == 2) : ?>
                                    <a href="?h=pengajuan_peminjaman&id=<?= $data['id_aset']; ?>" class="btn btn-warning text-white">Ajukan Kembali</a>
                                <?php elseif ($data['status'] == 3 || $data['status'] == 5) : ?>
                                    <a href="?h=pengajuan_pengembalian&id=<?= $data['id']; ?>" class="btn btn-info text-white">Ajukan Pengembalian</a>
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