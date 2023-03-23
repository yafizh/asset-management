<?php
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
    }

    if ($uploadOk) {
        try {
            $mysqli->begin_transaction();

            $q = "
            INSERT INTO aset (
                id_jenis_aset, 
                id_kategori_aset, 
                nama, 
                tanggal_masuk, 
                foto,
                status
            ) VALUES (
                '$id_jenis_aset', 
                '$id_kategori_aset', 
                '$nama', 
                '$tanggal_masuk', 
                '$target_file',
                '1'
            )";
            $mysqli->query($q);

            $id_aset = $mysqli->insert_id;

            foreach ($detail as $kolom => $nilai) {
                $q = "
                    INSERT INTO detail_aset (
                        id_aset, 
                        kolom, 
                        nilai
                    ) VALUES (
                        '$id_aset', 
                        '$kolom', 
                        '$nilai' 
                    )";
                $mysqli->query($q);
            }


            $mysqli->commit();

            echo "<script>alert('Tambah Data Berhasil!')</script>";
            echo
            isset($_GET['id_jenis_aset'])
                ?
                "<script>location.href = '?h=aset_per_jenis_aset&id=" . $_GET['id_jenis_aset'] . "';</script>"
                :
                "<script>location.href = '?h=aset';</script>";
        } catch (\Throwable $e) {
            echo "<script>alert('Tambah Data Gagal!')</script>";
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
                        <h6 class="text-white text-capitalize m-0">Tambah Aset</h6>
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
                                <?php if (isset($_GET['id_jenis_aset'])) : ?>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <?php if ($_GET['id_jenis_aset'] === $row['id']) : ?>
                                            <option value="<?= $row['id']; ?>" selected><?= $row['nama']; ?></option>
                                            <?php break; ?>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <option selected value="" disabled>Pilih</option>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                                    <?php endwhile; ?>
                                <?php endif; ?>
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
                                    <option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control p-2" name="nama" id="nama" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                            <input type="date" class="form-control p-2" name="tanggal_masuk" id="tanggal_masuk" autocomplete="off" required value="<?= Date("Y-m-d"); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input class="form-control" type="file" name="foto" id="foto" required accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Detail</label>
                            <div class="row" id="detail">
                                <div class="col-6 mb-3">
                                    <input type="text" class="form-control p-2" name="detail[]" autocomplete="off">
                                </div>
                                <div class="col-6 mb-3">
                                    <input type="text" class="form-control p-2" name="detail[]" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <?php if (isset($_GET['id_jenis_aset'])) : ?>
                                <a href="?h=aset_per_jenis_aset&id=<?= $_GET['id_jenis_aset']; ?>" class="btn btn-secondary">Kembali</a>
                            <?php else : ?>
                                <a href="?h=aset" class="btn btn-secondary">Kembali</a>
                            <?php endif; ?>
                            <button type="submit" name="submit" class="btn btn-success">Tambah</button>
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