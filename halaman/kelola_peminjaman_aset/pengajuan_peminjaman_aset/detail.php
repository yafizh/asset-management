<?php
$q = "
    SELECT 
        ka.id id_kategori_aset,
        ka.nama kategori_aset,
        a.nama,
        pegawai.nip,
        pegawai.nama nama_pegawai,
        pegawai.jabatan,
        pegawai.pangkat_golongan,
        DATE(pa.tanggal_waktu_pengajuan) tanggal_pengajuan,
        pa.id,  
        pa.jumlah,  
        pa.alasan,
        pa.status 
    FROM 
        aset a 
    INNER JOIN 
        kategori_aset ka 
    ON 
        ka.id=a.id_kategori_aset 
    INNER JOIN 
        peminjaman_aset pa 
    ON 
        a.id=pa.id_aset  
    INNER JOIN 
        pengguna 
    ON 
        pengguna.id=pa.id_user_peminjam  
    INNER JOIN 
        pegawai
    ON 
        pegawai.id_pengguna=pengguna.id  
    WHERE 
        pa.id=" . $_GET['id'] . "
    ORDER BY pa.id DESC
    ";
$result = $mysqli->query($q);
$data = $result->fetch_assoc();
$data2 = $mysqli->query('SELECT * FROM peminjaman_aset WHERE id=' . $_GET['id'])->fetch_assoc();
if (isset($_POST['submit'])) {
    $keterangan = $mysqli->real_escape_string($_POST['keterangan']);
    $status = $_POST['submit'] === 'terima' ? 3 : 2;

    $berita_acara = $_FILES["berita_acara"];

    $upload_berita_acara = true;
    if ($berita_acara['error'] != 4) {
        $target_dir = "uploads/berita_acara/";
        $imageFileType = strtolower(pathinfo($berita_acara['name'], PATHINFO_EXTENSION));
        $berita_acara_upload = $target_dir . Date("YmdHis") . '.' . $imageFileType;

        if ($imageFileType != "pdf") {
            echo "<script>alert('Hanya menerima file dengan format .pdf!')</script>";
            $upload_berita_acara = false;
        }

        if ($upload_berita_acara) {
            if (!is_dir($target_dir)) mkdir($target_dir, 0700, true);
            if (!move_uploaded_file($berita_acara["tmp_name"], $berita_acara_upload))
                echo "<script>alert('Gagal meng-upload file!')</script>";
        }
    } else $berita_acara_upload = '';

    try {
        $mysqli->begin_transaction();

        $q = "
            UPDATE 
                peminjaman_aset 
            SET 
                id_user_verifikator='" . $_SESSION['user']['id'] . "', 
                tanggal_waktu_verifikasi='" . Date('Y-m-d H:i:s') . "', 
                keterangan_verifikasi='$keterangan', 
                status='$status',
                berita_acara='$berita_acara_upload'
            WHERE 
                id=" . $data['id'] . "
        ";

        $mysqli->query($q);

        $mysqli->commit();
        if ($_POST['submit'] === 'terima')
            echo "<script>alert('Pengajuan Berhasil Diterima!')</script>";
        else
            echo "<script>alert('Pengajuan Berhasil Ditolak!')</script>";
        echo "<script>location.href = '?h=pengajuan_peminjaman_aset';</script>";
    } catch (\Throwable $e) {
        echo "<script>alert('Gagal!')</script>";
        $mysqli->rollback();
        throw $e;
    }
}
?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
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
                                <label class="form-label">Tanggal Pengajuan</label>
                                <input type="text" class="form-control p-2" disabled value="<?= tanggalIndonesiaString($data['tanggal_pengajuan']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah Yang Dipinjam</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['jumlah']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alasan Peminjaman</label>
                                <textarea class="form-control p-2" disabled><?= $data['alasan']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Detail Peminjam</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">NIP</label>
                                    <input type="text" class="form-control p-2" disabled value="<?= $data['nip']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control p-2" disabled value="<?= $data['nama_pegawai']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jabatan</label>
                                    <input type="text" class="form-control p-2" disabled value="<?= $data['jabatan']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pangkat/Golongan</label>
                                    <input type="text" class="form-control p-2" disabled value="<?= $data['pangkat_golongan']; ?>">
                                </div>
                                <?php if ($data['status'] == 1) : ?>
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan Penerimaan/Penolakan</label>
                                        <textarea class="form-control p-2" name="keterangan" id="keterangan" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="berita_acara" class="form-label">Berita Acara</label>
                                        <input type="file" class="form-control" name="berita_acara" id="berita_acara">
                                    </div>
                                <?php else : ?>
                                    <div class="mb-3">
                                        <label class="form-label">Keterangan Penerimaan/Penolakan</label>
                                        <textarea class="form-control p-2" disabled><?= $data2['keterangan_verifikasi'] ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="berita_acara" class="form-label">Berita Acara</label>
                                        <br>
                                        <a href="<?= $data2['berita_acara']; ?>" target="_blank" class="ps-1">PDF</a>
                                    </div>
                                <?php endif; ?>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex align-items-center flex-grow-1">
                                        <a href="?h=pengajuan_peminjaman_aset" class="btn btn-secondary">Kembali</a>
                                    </div>
                                    <?php if ($data['status'] == 1) : ?>
                                        <div class="d-flex justify-content-end align-items-center flex-wrap gap-1 flex-grow-1">
                                            <button type="submit" name="submit" value="tolak" class="btn btn-danger text-white" onclick="return confirm('Yakin?')">Tolak</button>
                                            <button type="submit" name="submit" value="terima" class="btn btn-success" onclick="return confirm('Yakin?')">Terima</button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>