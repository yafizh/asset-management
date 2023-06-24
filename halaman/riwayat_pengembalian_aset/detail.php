<?php
$q = "
    SELECT 
        ka.nama kategori_aset,
        pa.id,
        a.nama,
        DATE(pa.tanggal_waktu_pengajuan) tanggal_pengajuan,
        DATE(pa.tanggal_waktu_verifikasi) tanggal_pengajuan_ditentukan,
        pa.keterangan_verifikasi,
        pa1.alasan,
        pa.jumlah,
        pegawai.nama verifikator,
        pa1.status
    FROM 
        pengembalian_aset pa1 
    INNER JOIN 
        peminjaman_aset pa  
    ON 
        pa.id=pa1.id_peminjaman_aset 
    INNER JOIN 
        aset a 
    ON 
        a.id=pa.id_aset
    INNER JOIN 
        kategori_aset ka 
    ON 
        ka.id=a.id_kategori_aset  
    LEFT JOIN 
        pengguna 
    ON 
        pengguna.id=pa.id_user_verifikator 
    LEFT JOIN  
        pegawai 
    ON 
        pegawai.id_pengguna=pengguna.id 
    WHERE 
        pa1.id=" . $_GET['id'];
$result = $mysqli->query($q);
$data = $result->fetch_assoc();
?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
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
                                <label class="form-label">Alasan Pengembalian</label>
                                <textarea class="form-control p-2" rows="5" disabled><?= $data['alasan'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['jumlah'] ?>">
                            </div>
                            <?php if ($data['status'] != 1) : ?>
                                <hr>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Diverifikasi</label>
                                    <input type="text" class="form-control p-2" disabled value="<?= tanggalIndonesiaString($data['tanggal_pengajuan_ditentukan']); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Petugas Yang Memverifikasi</label>
                                    <input type="text" class="form-control p-2" disabled value="<?= $data['verifikator'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea class="form-control p-2" rows="5" disabled><?= $data['keterangan_verifikasi'] ?></textarea>
                                </div>
                            <?php endif; ?>
                            <div class="d-flex justify-content-between">
                                <a href="?h=riwayat_pengembalian_aset" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>