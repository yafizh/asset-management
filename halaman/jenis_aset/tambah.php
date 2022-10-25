<?php

if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $keterangan = $mysqli->real_escape_string($_POST['keterangan']);

    $q = "INSERT INTO jenis_aset (nama, keterangan) VALUES ('$nama', '$keterangan')";
    if ($mysqli->query($q)) {
        echo "<script>alert('Tambah Data Berhasil!')</script>";
        echo "<script>location.href = '?h=jenis_aset';</script>";
    } else {
        echo "<script>alert('Tambah Data Gagal!')</script>";
        die($mysqli->error);
    }
}


?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Tambah Jenis Aset</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="nama" id="nama" autocomplete="off" autofocus required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <div class="input-group input-group-outline">
                                <textarea class="form-control" rows="5" id="keterangan" name="keterangan" required autocomplete="off"></textarea>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="?h=jenis_aset" class="btn btn-secondary">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-success">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>