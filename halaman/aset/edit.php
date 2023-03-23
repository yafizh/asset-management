<?php

$q = "SELECT * FROM aset WHERE id=" . $_GET['id'];
$result = $mysqli->query($q);
$data = $result->fetch_assoc();
$data['detail'] = $mysqli->query("SELECT * FROM detail_aset WHERE id_aset=" . $data['id'])->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['submit'])) {
    $id_jenis_aset = $mysqli->real_escape_string($_POST['id_jenis_aset']);
    $id_kategori_aset = $mysqli->real_escape_string($_POST['id_kategori_aset']);
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $tanggal_masuk = $mysqli->real_escape_string($_POST['tanggal_masuk']);

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
        try {
            $mysqli->begin_transaction();

            $q = "
            UPDATE aset SET 
                id_jenis_aset='$id_jenis_aset', 
                id_kategori_aset='$id_kategori_aset', 
                nama='$nama', 
                tanggal_masuk='$tanggal_masuk', 
                detail='" . json_encode($detail) . "', 
                foto='$target_file' 
            WHERE 
                id=" . $data['id'];

            $mysqli->query("DELETE FROM detail_aset WHERE id_aset=" . $data['id']);
            foreach ($detail as $kolom => $nilai) {
                $q = "
                    INSERT INTO detail_aset (
                        id_aset, 
                        kolom, 
                        nilai
                    ) VALUES (
                        '" . $data['id'] . "', 
                        '$kolom', 
                        '$nilai' 
                    )";
                $mysqli->query($q);
            }


            $mysqli->commit();

            echo "<script>alert('Edit Data Berhasil!')</script>";
            echo "<script>location.href = '?h=detail_aset&id=" . $data['id'] . "';</script>";
        } catch (\Throwable $e) {
            echo "<script>alert('Edit Data Gagal!')</script>";
            $mysqli->rollback();
            throw $e;
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
                            $q = "SELECT * FROM kategori_aset";
                            $result = $mysqli->query($q);
                            ?>
                            <label for="id_kategori_aset" class="form-label">Kategori Aset</label>
                            <select class="form-control p-2" id="id_kategori_aset" name="id_kategori_aset" required>
                                <option selected value="" disabled>Pilih</option>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <?php if ($row['id'] === $data['id_kategori_aset']) : ?>
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
                            <label class="form-label">Detail</label>
                            <div class="row" id="detail">
                                <?php foreach ($data['detail'] as $value) : ?>
                                    <div class="col-6 mb-3">
                                        <input type="text" class="form-control p-2" name="detail[]" autocomplete="off" value="<?= $value['kolom']; ?>">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <input type="text" class="form-control p-2" name="detail[]" autocomplete="off" value="<?= $value['nilai']; ?>">
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