<?php

$q = "
    SELECT 
        a.*,
        ka.nama kategori_aset,
        ja.nama jenis_aset
    FROM 
        aset a 
    INNER JOIN 
        kategori_aset ka
    ON 
        ka.id=a.id_kategori_aset 
    INNER JOIN 
        jenis_aset ja 
    ON 
        ja.id=ka.id_jenis_aset 
    WHERE 
        a.id=" . $_GET['id'];
$result = $mysqli->query($q);
$data = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    try {
        $mysqli->begin_transaction();

        $q = "
        UPDATE aset SET 
            nama='$nama' 
        WHERE 
            id=" . $data['id'];

        $mysqli->query($q);

        $mysqli->commit();

        echo "<script>alert('Edit Data Berhasil!')</script>";
        echo "<script>location.href = '?h=aset&id_jenis_aset=" . $_GET['id_jenis_aset'] . "&id_kategori_aset=" . $_GET['id_kategori_aset'] . "';</script>";
    } catch (\Throwable $e) {
        echo "<script>alert('Edit Data Gagal!')</script>";
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
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Edit Aset</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="id_jenis_aset" class="form-label">Jenis Aset</label>
                            <input type="text" class="form-control" disabled value="<?= $data['jenis_aset']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="id_kategori_aset" class="form-label">Kategori Aset</label>
                            <input type="text" class="form-control" disabled value="<?= $data['kategori_aset']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control p-2" name="nama" id="nama" autocomplete="off" required value="<?= $data['nama']; ?>">
                        </div>
                        <div class="d-flex justify-content-between">
                        <a href="?h=aset&id_jenis_aset=<?= $_GET['id_jenis_aset'] ?>&id_kategori_aset=<?= $_GET['id_kategori_aset'] ?>" class="btn btn-secondary">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>