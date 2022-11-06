<?php
$q = "
    SELECT 
        ja.id AS id_jenis_aset,
        ja.nama AS jenis_aset,
        sa.nama AS sifat_aset,
        a.*,
        DATE(pa.timestamp_pengajuan) AS tanggal_pengajuan,
        pa.id AS id_peminjaman_aset,  
        pa.alasan_peminjaman  
    FROM 
        aset AS a 
    INNER JOIN 
        jenis_aset AS ja 
    ON 
        ja.id=a.id_jenis_aset 
    INNER JOIN 
        sifat_aset AS sa 
    ON 
        sa.id=a.id_sifat_aset 
    INNER JOIN 
        peminjaman_aset AS pa 
    ON 
        a.id=pa.id_aset  
    WHERE 
        a.id=" . $_GET['id'] ."
    ORDER BY pa.id DESC
    ";
$result = $mysqli->query($q);
$data = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $keterangan = $mysqli->real_escape_string($_POST['keterangan']);
    $status = $_POST['submit'] === 'terima' ? 3 : 2;

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

    if ($mysqli->query($q)) {
        if ($_POST['submit'] === 'terima')
            echo "<script>alert('Pengajuan Berhasil Diterima!')</script>";
        else
            echo "<script>alert('Pengajuan Berhasil Ditolak!')</script>";
        echo "<script>location.href = '?h=pengajuan_peminjaman_aset_per_jenis_aset&id=" . $data['id_jenis_aset'] . "';</script>";
    } else {
        echo "<script>alert('Gagal!')</script>";
        die($mysqli->error);
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
                        <h6 class="text-white text-capitalize m-0">Detail Aset</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="" method="POST">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Sifat Aset</label>
                                    <input type="text" class="form-control p-2" disabled value="<?= $data['sifat_aset'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control p-2" disabled value="<?= $data['nama'] ?>">
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
                                    <label class="form-label">Alasan Pengajuan</label>
                                    <textarea class="form-control p-2" disabled><?= $data['alasan_peminjaman']; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan Penerimaan/Penolakan</label>
                                    <textarea class="form-control p-2" name="keterangan" id="keterangan" required></textarea>
                                </div>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex align-items-center flex-grow-1">
                                        <a href="?h=pengajuan_peminjaman_aset_per_jenis_aset&id=<?= $data['id_jenis_aset']; ?>" class="btn btn-secondary">Kembali</a>
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