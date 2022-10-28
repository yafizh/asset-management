<?php


$q = "SELECT * FROM aset WHERE id=" . $_GET['id'];
$result = $mysqli->query($q);
$data = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $id_jenis_aset = $mysqli->real_escape_string($_POST['id_jenis_aset']);
    $id_sifat_aset = $mysqli->real_escape_string($_POST['id_sifat_aset']);
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $tanggal_masuk = $mysqli->real_escape_string($_POST['tanggal_masuk']);
    $keterangan = $mysqli->real_escape_string($_POST['keterangan']);

    $detail = [];
    for ($i = 0; $i < count($_POST['detail']); $i += 2) {
        $key = $mysqli->real_escape_string($_POST['detail'][$i]);
        $value = $mysqli->real_escape_string($_POST['detail'][$i + 1]);
        if (empty(trim($key))) continue;
        if (empty(trim($key)) && empty(trim($value))) continue;
        $detail[$key] = $value;
    }

    $foto = $_FILES["foto"];
    $uploadOk = true;
    if ($foto['error'] != 4) {
        $target_dir = "uploads/gambar_aset/";
        $imageFileType = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        $target_file = $target_dir . Date("YmdHis") . '.' . $imageFileType;
        $check = getimagesize($foto["tmp_name"]);
        if ($check === false) {
            echo "<script>alert('File yang diupload bukan gambar!')</script>";
            $uploadOk = false;
        }

        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        ) {
            echo "<script>alert('Hanya menerima gambar dengan format .png, .jpg, .jpeg!')</script>";
            $uploadOk = false;
        }

        if ($uploadOk) {
            if (!is_dir($target_dir)) mkdir($target_dir, 0700, true);
            if (!move_uploaded_file($foto["tmp_name"], $target_file))
                echo "<script>alert('Gagal meng-upload gambar!')</script>";
        }
    } else $target_file = $data['foto'];

    if ($uploadOk) {
        $q = "
            UPDATE aset SET 
                id_jenis_aset='$id_jenis_aset', 
                id_sifat_aset='$id_sifat_aset', 
                nama='$nama', 
                tanggal_masuk='$tanggal_masuk', 
                detail='" . json_encode($detail) . "', 
                foto='$target_file', 
                keterangan='$keterangan' 
            WHERE 
                id=" . $data['id'];

        if ($mysqli->query($q)) {
            echo "<script>alert('Edit Data Berhasil!')</script>";
            echo "<script>location.href = '?h=detail_aset&id=" . $data['id'] . "';</script>";
        } else {
            echo "<script>alert('Edit Data Gagal!')</script>";
            die($mysqli->error);
        }
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
                            <?php
                            $q = "SELECT * FROM jenis_aset";
                            $result = $mysqli->query($q);
                            ?>
                            <label for="id_jenis_aset" class="form-label">Jenis Aset</label>
                            <select class="form-control p-2" id="id_jenis_aset" name="id_jenis_aset" required>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <?php if ($row['id'] === $data['id_jenis_aset']) : ?>
                                        <option value="<?= $row['id']; ?>" selected><?= $row['nama']; ?></option>
                                    <?php else : ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <?php
                            $q = "SELECT * FROM sifat_aset";
                            $result = $mysqli->query($q);
                            ?>
                            <label for="id_sifat_aset" class="form-label">Sifat Aset</label>
                            <select class="form-control p-2" id="id_sifat_aset" name="id_sifat_aset" required>
                                <option selected value="" disabled>Pilih</option>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <?php if ($row['id'] === $data['id_sifat_aset']) : ?>
                                        <option value="<?= $row['id']; ?>" selected><?= $row['nama']; ?></option>
                                    <?php else : ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control p-2" name="nama" id="nama" autocomplete="off" required value="<?= $data['nama']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                            <input type="date" class="form-control p-2" name="tanggal_masuk" id="tanggal_masuk" autocomplete="off" required value="<?= $data['tanggal_masuk']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input class="form-control" type="file" name="foto" id="foto">
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control p-2" rows="5" id="keterangan" name="keterangan" required autocomplete="off"><?= $data['keterangan']; ?></textarea>
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
                                <div class="col-6 mb-3">
                                    <input type="text" class="form-control p-2" name="detail[]" autocomplete="off">
                                </div>
                                <div class="col-6 mb-3">
                                    <input type="text" class="form-control p-2" name="detail[]" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="?h=detail_aset&id=<?= $data['id']; ?>" class="btn btn-secondary">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('input', '#detail input', () => {
        let add_detail = false;
        $("#detail input").each((index, input) => {
            if (input.value) add_detail = true;
            else add_detail = false;
        });
        if (add_detail) {
            $("#detail").append(`
                <div class="col-6 mb-3">
                    <input type="text" class="form-control p-2" name="detail[]" autocomplete="off">
                </div>
                <div class="col-6 mb-3">
                    <input type="text" class="form-control p-2" name="detail[]" autocomplete="off">
                </div>
            `);
        }
    });
</script>