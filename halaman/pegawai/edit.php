<?php

$q = "SELECT * FROM pegawai WHERE id=" . $_GET['id'];
$result = $mysqli->query($q);
$data = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $nip = $mysqli->real_escape_string($_POST['nip']);
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $tanggal_lahir = $mysqli->real_escape_string($_POST['tanggal_lahir']);
    $tempat_lahir = $mysqli->real_escape_string($_POST['tempat_lahir']);
    $jabatan = $mysqli->real_escape_string($_POST['jabatan']);
    $pangkat_golongan = $mysqli->real_escape_string($_POST['pangkat_golongan']);
    $tmt = $mysqli->real_escape_string($_POST['tmt']);
    $pendidikan_terakhir = $mysqli->real_escape_string($_POST['pendidikan_terakhir']);

    $ijazah_pendidikan_terakhir = $_FILES["ijazah_pendidikan_terakhir"];
    $foto = $_FILES["foto"];
    $sk_tmt = $_FILES["sk_tmt"];

    $upload_foto = true;
    if ($foto['error'] != 4) {
        $target_dir = "uploads/gambar_pegawai/";
        $imageFileType = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        $foto_upload = $target_dir . Date("YmdHis") . '.' . $imageFileType;
        $check = getimagesize($foto["tmp_name"]);
        if ($check === false) {
            echo "<script>alert('File yang diupload bukan gambar!')</script>";
            $upload_foto = false;
        }

        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        ) {
            echo "<script>alert('Hanya menerima gambar dengan format .png, .jpg, .jpeg!')</script>";
            $upload_foto = false;
        }

        if ($upload_foto) {
            if (!is_dir($target_dir)) mkdir($target_dir, 0700, true);
            if (!move_uploaded_file($foto["tmp_name"], $foto_upload))
                echo "<script>alert('Gagal meng-upload gambar!')</script>";
        }
    } else $foto_upload = $data['foto'];

    $upload_sk_tmt = true;
    if ($sk_tmt['error'] != 4) {
        $target_dir = "uploads/sk_tmt_pegawai/";
        $fileType = strtolower(pathinfo($sk_tmt['name'], PATHINFO_EXTENSION));
        $sk_tmt_upload = $target_dir . Date("YmdHis") . '.' . $fileType;
        $check = getimagesize($sk_tmt["tmp_name"]);

        if ($fileType != "pdf") {
            echo "<script>alert('Hanya menerima SK TMT dengan format .pdf!')</script>";
            $upload_sk_tmt = false;
        }

        if ($upload_sk_tmt) {
            if (!is_dir($target_dir)) mkdir($target_dir, 0700, true);
            if (!move_uploaded_file($sk_tmt["tmp_name"], $sk_tmt_upload))
                echo "<script>alert('Gagal meng-upload SK TMT!')</script>";
        }
    } else $sk_tmt_upload = $data['sk_tmt'];

    $upload_ijazah = true;
    if ($ijazah_pendidikan_terakhir['error'] != 4) {
        $target_dir = "uploads/ijazah_pegawai/";
        $fileType = strtolower(pathinfo($ijazah_pendidikan_terakhir['name'], PATHINFO_EXTENSION));
        $ijazah_pendidikan_terakhir_upload = $target_dir . Date("YmdHis") . '.' . $fileType;
        $check = getimagesize($ijazah_pendidikan_terakhir["tmp_name"]);

        if ($fileType != "pdf") {
            echo "<script>alert('Hanya menerima ijazah dengan format .pdf!')</script>";
            $upload_ijazah = false;
        }

        if ($upload_ijazah) {
            if (!is_dir($target_dir)) mkdir($target_dir, 0700, true);
            if (!move_uploaded_file($ijazah_pendidikan_terakhir["tmp_name"], $ijazah_pendidikan_terakhir_upload))
                echo "<script>alert('Gagal meng-upload ijazah!')</script>";
        }
    } else $ijazah_pendidikan_terakhir_upload = $data['ijazah_pendidikan_terakhir'];

    $q = "
        UPDATE pengguna SET 
            username='$nip' 
        WHERE 
            id=" . $data['id_pengguna'];

    if ($mysqli->query($q)) {
        $q = "
            UPDATE pegawai SET 
                nip='$nip', 
                nama='$nama', 
                tanggal_lahir='$tanggal_lahir', 
                tempat_lahir='$tempat_lahir', 
                jabatan='$jabatan', 
                pangkat_golongan='$pangkat_golongan', 
                tmt='$tmt', 
                sk_tmt='$sk_tmt_upload', 
                pendidikan_terakhir='$pendidikan_terakhir', 
                foto='$foto_upload', 
                ijazah_pendidikan_terakhir='$ijazah_pendidikan_terakhir_upload' 
            WHERE 
                id=" . $_GET['id'];

        if ($mysqli->query($q)) {
            echo "<script>alert('Edit Data Berhasil!')</script>";
            echo "<script>location.href = '?h=detail_pegawai&id=" . $_GET['id'] . "';</script>";
            exit;
        }
    }

    echo "<script>alert('Edit Data Gagal!')</script>";
    die($mysqli->error);
}


?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Edit Pegawai</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="nip" id="nip" autocomplete="off" required value="<?= $data['nip']; ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="nama" id="nama" autocomplete="off" required value="<?= $data['nama']; ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" autocomplete="off" required value="<?= $data['tempat_lahir']; ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal lahir</label>
                            <div class="input-group input-group-outline">
                                <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" autocomplete="off" required value="<?= $data['tanggal_lahir']; ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="jabatan" id="jabatan" autocomplete="off" required value="<?= $data['jabatan']; ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="pangkat_golongan" class="form-label">Pangkat/Golongan</label>
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="pangkat_golongan" id="pangkat_golongan" autocomplete="off" required value="<?= $data['pangkat_golongan']; ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tmt" class="form-label">TMT</label>
                            <div class="input-group input-group-outline">
                                <input type="date" class="form-control" name="tmt" id="tmt" autocomplete="off" required value="<?= $data['tmt']; ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                            <select class="form-control p-2" id="pendidikan_terakhir" name="pendidikan_terakhir" required>
                                <option selected value="" disabled>Pilih</option>
                                <option <?= $data['pendidikan_terakhir'] === "SMA/SMK" ? 'selected' : ''; ?> value="SMA/SMK">SMA/SMK</option>
                                <option <?= $data['pendidikan_terakhir'] === "S1" ? 'selected' : ''; ?> value="S1">S1</option>
                                <option <?= $data['pendidikan_terakhir'] === "S2" ? 'selected' : ''; ?> value="S2">S2</option>
                                <option <?= $data['pendidikan_terakhir'] === "S3" ? 'selected' : ''; ?> value="S3">S3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input class="form-control" type="file" name="foto" id="foto">
                        </div>
                        <div class="mb-3">
                            <label for="ijazah_pendidikan_terakhir" class="form-label">Ijazah Terakhir</label>
                            <input class="form-control" type="file" name="ijazah_pendidikan_terakhir" id="ijazah_pendidikan_terakhir">
                        </div>
                        <div class="mb-3">
                            <label for="sk_tmt" class="form-label">SK TMT</label>
                            <input class="form-control" type="file" name="sk_tmt" id="sk_tmt">
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="?h=pegawai" class="btn btn-secondary">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>