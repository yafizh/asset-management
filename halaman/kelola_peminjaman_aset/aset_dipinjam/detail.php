<?php
$q = "
    SELECT 
        ja.id AS id_jenis_aset,
        ja.nama AS jenis_aset,
        sa.nama AS sifat_aset,
        a.id,
        a.nama,
        a.tanggal_masuk,
        a.detail,
        a.foto,
        DATE(pa.timestamp_pengajuan) AS tanggal_pengajuan,
        DATE(pa.timestamp_pengajuan_ditentukan) AS tanggal_pengajuan_ditentukan,
        pa.keterangan_pengajuan,
        pa.alasan_peminjaman,
        pa.status
    FROM 
        peminjaman_aset AS pa  
    INNER JOIN 
        aset AS a 
    ON 
        a.id=pa.id_aset
    INNER JOIN 
        sifat_aset AS sa 
    ON 
        sa.id=a.id_sifat_aset
    INNER JOIN 
        jenis_aset AS ja 
    ON 
        ja.id=a.id_jenis_aset  
    WHERE 
        a.id=" . $_GET['id'];
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
                        <h6 class="text-white text-capitalize m-0">Detail Aset</h6>
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
                                <label class="form-label">Tanggal Masuk</label>
                                <input type="text" class="form-control p-2" disabled value="<?= tanggalIndonesiaString($data['tanggal_masuk']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Detail</label>
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
                                <label class="form-label">Tanggal Pengajuan</label>
                                <input type="text" class="form-control p-2" disabled value="<?= tanggalIndonesiaString($data['tanggal_pengajuan']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label d-block">Status Pengajuan</label>
                                <span class="badge bg-gradient-success">Pengajuan Diterima</span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alasan Peminjaman</label>
                                <textarea class="form-control p-2" rows="5" disabled><?= $data['alasan_peminjaman'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pengajuan <?= $data['status'] == 2 ? 'Ditolak' : 'Diterima';  ?></label>
                                <input type="text" class="form-control p-2" disabled value="<?= tanggalIndonesiaString($data['tanggal_pengajuan_ditentukan']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan Diterima/Ditolak</label>
                                <textarea class="form-control p-2" rows="5" disabled><?= $data['keterangan_pengajuan'] ?></textarea>
                            </div>
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="d-flex align-items-center flex-grow-1">
                                    <a href="?h=aset_dipinjam_per_jenis_aset&id=<?= $data['id_jenis_aset']; ?>" class="btn btn-secondary">Kembali</a>
                                </div>
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