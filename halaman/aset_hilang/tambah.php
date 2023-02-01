<?php
$q = "
SELECT 
    ja.nama jenis_aset,
    ka.nama kategori_aset,
    a.* 
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
WHERE 
    a.id=" . $_GET['id'];
$result = $mysqli->query($q);
$data = $result->fetch_assoc();
$data['detail'] = $mysqli->query("SELECT * FROM detail_aset WHERE id_aset=" . $_GET['id'])->fetch_all(MYSQLI_ASSOC);
if (isset($_POST['submit'])) {
    $id = $mysqli->real_escape_string($_GET['id']);
    $tanggal = $mysqli->real_escape_string($_POST['tanggal']);
    $keterangan = $mysqli->real_escape_string($_POST['keterangan']);

    try {
        $mysqli->begin_transaction();

        $q = "
        INSERT INTO aset_hilang (
            id_aset, 
            tanggal, 
            keterangan 
        ) VALUES (
            '$id',
            '$tanggal',
            '$keterangan'
        )";
        $mysqli->query($q);
        $mysqli->query("UPDATE aset SET status=3 WHERE id=$id");

        $mysqli->commit();
        echo "<script>alert('Pelaporan Aset Hilang Berhasil!')</script>";
        echo "<script>location.href = '?h=detail_aset&id=$id';</script>";
    } catch (\Throwable $e) {
        echo "<script>alert('Pelaporan Aset Hilang Gagal!')</script>";
        die($mysqli->error);
        $mysqli->rollback();
        throw $e;
    }
}
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-danger shadow-danger border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Pelaporan Aset Hilang</h6>
                    </div>
                </div>
                <div class="card-body">
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
                            <label for="tanggal" class="form-label">Tanggal Hilang</label>
                            <input type="date" class="form-control p-2" name="tanggal" id="tanggal" required value="<?= Date("Y-m-d"); ?>">
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