<?php
if (isset($_POST['submit'])) {
    $password_lama = $mysqli->real_escape_string($_POST['password_lama']);
    $password_baru = $mysqli->real_escape_string($_POST['password_baru']);
    $konfirmasi_password_baru = $mysqli->real_escape_string($_POST['konfirmasi_password_baru']);

    if ($password_lama == $_SESSION['user']['password']) {
        if ($password_baru == $konfirmasi_password_baru) {
            $q = "UPDATE pengguna SET password='$password_baru' WHERE id=" . $_SESSION['user']['id'];

            if ($mysqli->query($q))
                echo "<script>alert('Password Berhasil Diperbaharui!')</script>";
            else {
                echo "<script>alert('Password Gagal Diperbaharui!')</script>";
                die($mysqli->error);
            }
        } else
            echo "<script>alert('Password Baru Tidak Sama!')</script>";
    } else
        echo "<script>alert('Password Lama Salah!')</script>";
}
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Ganti Password</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="password_lama" class="form-label">Password Lama</label>
                            <input type="password" class="form-control p-2" name="password_lama" id="password_lama" autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password_baru" class="form-label">Password Baru</label>
                            <input type="password" class="form-control p-2" name="password_baru" id="password_baru">
                        </div>
                        <div class="mb-3">
                            <label for="konfirmasi_password_baru" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control p-2" name="konfirmasi_password_baru" id="konfirmasi_password_baru">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" name="submit" class="btn btn-success" onclick="return confirm('Yakin?')">Ganti Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>