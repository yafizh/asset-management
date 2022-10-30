<?php
$q = "
SELECT 
    ja.nama AS jenis_aset,
    sa.nama AS sifat_aset,
    a.* 
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
WHERE 
    a.id=" . $_GET['id'];
$result = $mysqli->query($q);
$data = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $id = $mysqli->real_escape_string($_GET['id']);
    $tanggal_mulai = $mysqli->real_escape_string($_POST['tanggal_mulai']);
    $keterangan = $mysqli->real_escape_string($_POST['keterangan']);

    $q = "
    INSERT INTO pemeliharaan_aset (
        id_aset, 
        tanggal_mulai, 
        keterangan 
    ) VALUES (
        '$id',
        '$tanggal_mulai',
        '$keterangan'
    )";

    if ($mysqli->query($q)) {
        echo "<script>alert('Pemeliharaan Aset Berhasil Ditambahkan!')</script>";
        echo "<script>location.href = '?h=detail_aset&id=$id';</script>";
    } else {
        echo "<script>alert('Pemeliharaan Aset Gagal Ditambahkan!')</script>";
        die($mysqli->error);
    }
}
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-warning shadow-warning border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Tambah Data Pemeliharaan Aset</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
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
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai Pemeliharaan</label>
                            <input type="date" class="form-control p-2" name="tanggal_mulai" id="tanggal_mulai" required value="<?= Date("Y-m-d"); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="5" class="form-control" required autocomplete="off" autofocus></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="?h=detail_aset&id=<?= $data['id'] ?>" class="btn btn-secondary">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-success" onclick="return confirm('Yakin?')">Lakukan Pelaporan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>