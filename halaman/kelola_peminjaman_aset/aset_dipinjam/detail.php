<?php
$q = "
    SELECT 
        ja.id id_jenis_aset,
        ja.nama jenis_aset,
        ka.nama kategori_aset,
        a.id,
        a.nama,
        a.tanggal_masuk,
        a.foto,
        p.nip,
        p.nama nama_pegawai,
        DATE(pa.timestamp_pengajuan) tanggal_pengajuan,
        DATE(pa.timestamp_pengajuan_ditentukan) tanggal_pengajuan_ditentukan,
        pa.keterangan_pengajuan,
        pa.alasan_peminjaman,
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
    INNER JOIN 
        jenis_aset ja 
    ON 
        ja.id=a.id_jenis_aset  
    INNER JOIN 
        pegawai p 
    ON 
        p.id=pa.id_pegawai  
    WHERE 
        a.id=" . $_GET['id'];
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
                                <label class="form-label">Kategori Aset</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['kategori_aset'] ?>">
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
                                <?php foreach ($data['detail'] as $key => $value) : ?>
                                    <div class="row ps-1 mb-2">
                                        <div class="col-auto" style="width: 120px;"><?= $value['kolom']; ?></div>
                                        <div class="col-8">: <?= $value['nilai']; ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label">NIP Peminjam</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['nip']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Peminjam</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['nama_pegawai']; ?>">
                            </div>
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