<?php
$q = "
    SELECT 
        ka.nama kategori_aset,
        pa.id,
        pa.jumlah,
        a.nama
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

if (isset($_POST['submit'])) {
    $alasan_pengembalian = $mysqli->real_escape_string($_POST['alasan_pengembalian']);

    $q = "
    INSERT INTO pengembalian_aset (
        id_peminjaman_aset,
        alasan,
        tanggal_waktu_pengajuan,
        status 
    ) VALUES (
        '" . $_GET['id'] . "',
        '" . $alasan_pengembalian . "',
        '" . Date("Y-m-d") . "',
        1
    )";

    if ($mysqli->query($q)) {
        $last_id = $mysqli->insert_id;
        echo "<script>alert('Pengajuan Pengembalian Aset Berhasil!')</script>";
        echo "<script>location.href = '?h=detail_riwayat_pengembalian_aset&id=" . $last_id . "'</script>";
    } else {
        echo "<script>alert('Pengajuan Pengembalian Aset Gagal!')</script>";
        die($mysqli->error);
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
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Kategori Aset</label>
                                    <input type="text" class="form-control p-2" disabled value="<?= $data['kategori_aset'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control p-2" disabled value="<?= $data['nama'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" class="form-control p-2" disabled value="<?= $data['lokasi']; ?>">
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Pengembalian</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Yang Dipinjam</label>
                                    <input type="text" class="form-control p-2" disabled value="<?= $data['jumlah'] ?>">
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <label class="form-label" for="alasan_pengembalian">Alasan Pengembalian</label>
                                    <textarea class="form-control p-2" rows="5" name="alasan_pengembalian" id="alasan_pengembalian"></textarea>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="?h=detail_riwayat_peminjaman_aset" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" name="submit" class="btn btn-success text-white">Ajukan Pengembalian</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>