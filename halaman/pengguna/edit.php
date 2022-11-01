<?php

$q = "SELECT * FROM pengguna WHERE id=" . $_GET['id'];
$result = $mysqli->query($q);
$data = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = empty($_POST['password']) ? $data['password'] : $mysqli->real_escape_string($_POST['password']);
    $status = $mysqli->real_escape_string($_POST['status']);

    $q = "UPDATE pengguna SET username='$username', password='$password', status='$status' WHERE id=" . $_GET['id'];
    if ($mysqli->query($q)) {
        echo "<script>alert('Edit Data Berhasil!')</script>";
        echo "<script>location.href = '?h=pengguna';</script>";
    } else {
        echo "<script>alert('Edit Data Gagal!')</script>";
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
                        <h6 class="text-white text-capitalize m-0">Edit Pengguna</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="username" id="username" autocomplete="off" required value="<?= $data['username']; ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group input-group-outline">
                                <input type="password" class="form-control" name="password" id="password" autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control p-2" id="status" name="status" required>
                                <option selected value="" disabled>Pilih</option>
                                <option value="admin" <?= $data['status'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="petugas" <?= $data['status'] === 'petugas' ? 'selected' : ''; ?>>Petugas</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="?h=jenis_aset" class="btn btn-secondary">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>