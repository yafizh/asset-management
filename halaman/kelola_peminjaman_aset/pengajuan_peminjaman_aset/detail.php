<?php
$q = "
    SELECT 
        ja.nama jenis_aset,
        ka.id id_kategori_aset,
        ka.nama kategori_aset,
        a.*,
        p.nip,
        p.nama nama_pegawai,
        DATE(pa.timestamp_pengajuan) tanggal_pengajuan,
        pa.id id_peminjaman_aset,  
        pa.alasan_peminjaman  
    FROM 
        aset a 
    INNER JOIN 
        jenis_aset ja 
    ON 
        ja.id=a.id_jenis_aset 
    INNER JOIN 
        kategori_aset ka 
    ON 
        ka.id=a.id_kategori_aset 
    INNER JOIN 
        peminjaman_aset pa 
    ON 
        a.id=pa.id_aset  
    INNER JOIN 
        pegawai p 
    ON 
        p.id=pa.id_pegawai  
    WHERE 
        a.id=" . $_GET['id'] . "
    ORDER BY pa.id DESC
    ";
$result = $mysqli->query($q);
$data = $result->fetch_assoc();
$data['detail'] = $mysqli->query("SELECT * FROM detail_aset WHERE id_aset=" . $_GET['id'])->fetch_all(MYSQLI_ASSOC);
if (isset($_POST['submit'])) {
    $keterangan = $mysqli->real_escape_string($_POST['keterangan']);
    $status = $_POST['submit'] === 'terima' ? 3 : 2;

    try {
        $mysqli->begin_transaction();

        $q = "
            UPDATE 
                peminjaman_aset 
            SET 
                timestamp_pengajuan_ditentukan='" . Date('Y-m-d H:i:s') . "', 
                keterangan_pengajuan='$keterangan', 
                status='$status'
            WHERE 
                id=" . $data['id_peminjaman_aset'] . "
        ";

        $mysqli->query($q);
        if($status == 3)
            $mysqli->query("UPDATE aset SET status=5 WHERE id=" . $_GET['id']);

        $mysqli->commit();
        if ($_POST['submit'] === 'terima')
            echo "<script>alert('Pengajuan Berhasil Diterima!')</script>";
        else
            echo "<script>alert('Pengajuan Berhasil Ditolak!')</script>";
        echo "<script>location.href = '?h=pengajuan_peminjaman_aset_per_kategori_aset&id=" . $data['id_kategori_aset'] . "';</script>";
    } catch (\Throwable $e) {
        echo "<script>alert('Gagal!')</script>";
        $mysqli->rollback();
        throw $e;
    }
}
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
                        <h6 class="text-white text-capitalize m-0">Detail Pengajuan Peminjaman Aset</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="" method="POST">
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
                                    <label class="form-label">Alasan Pengajuan</label>
                                    <textarea class="form-control p-2" disabled><?= $data['alasan_peminjaman']; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan Penerimaan/Penolakan</label>
                                    <textarea class="form-control p-2" name="keterangan" id="keterangan" required></textarea>
                                </div>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex align-items-center flex-grow-1">
                                        <a href="?h=pengajuan_peminjaman_aset_per_kategori_aset&id=<?= $data['id_kategori_aset']; ?>" class="btn btn-secondary">Kembali</a>
                                    </div>
                                    <div class="d-flex justify-content-end align-items-center flex-wrap gap-1 flex-grow-1">
                                        <button type="submit" name="submit" value="tolak" class="btn btn-danger text-white" onclick="return confirm('Yakin?')">Tolak</button>
                                        <button type="submit" name="submit" value="terima" class="btn btn-success" onclick="return confirm('Yakin?')">Terima</button>
                                    </div>
                                </div>
                            </div>
                        </form>

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