<?php
$data = $mysqli->query("SELECT * FROM kategori_aset WHERE id=" . $_GET['id'])->fetch_assoc();
if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);

    $q = "UPDATE kategori_aset SET nama='$nama' WHERE id=" . $_GET['id'];
    if ($mysqli->query($q)) {
        echo "<script>alert('Edit Data Berhasil!')</script>";
        echo "<script>location.href = '?h=kategori_aset';</script>";
    } else {
        echo "<script>alert('Edit Data Gagal!')</script>";
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
                        <h6 class="text-white text-capitalize m-0">Edit Kategori Aset</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="nama" id="nama" autocomplete="off" required value="<?= $data['nama']; ?>">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="?h=kategori_aset" class="btn btn-secondary">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>