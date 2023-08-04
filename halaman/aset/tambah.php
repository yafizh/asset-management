<?php

$query = "
    SELECT 
        ka.nama kategori_aset,
        ja.nama jenis_aset 
    FROM 
        kategori_aset ka 
    INNER JOIN 
        jenis_aset ja 
    ON 
        ja.id=ka.id_jenis_aset 
    WHERE 
        ka.id=" . $_GET['id_kategori_aset'] . "
";
$result = $mysqli->query($query)->fetch_assoc();
if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $detail = [];
    for ($i = 0; $i < count($_POST['detail']); $i += 2) {
        $key = $mysqli->real_escape_string($_POST['detail'][$i]);
        $value = $mysqli->real_escape_string($_POST['detail'][$i + 1]);
        if (empty(trim($key))) continue;
        if (empty(trim($key)) && empty(trim($value))) continue;
        $detail[$key] = $value;
    }

    try {
        $mysqli->begin_transaction();

        $q = "
        INSERT INTO aset (
            id_kategori_aset, 
            nama,
            jumlah 
        ) VALUES (
            '" . $_GET['id_kategori_aset'] . "', 
            '$nama',
            0
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
        echo "<script>location.href = '?h=aset&id_jenis_aset=" . $_GET['id_jenis_aset'] . "&id_kategori_aset=" . $_GET['id_kategori_aset'] . "';</script>";
    } catch (\Throwable $e) {
        echo "<script>alert('Tambah Data Gagal!')</script>";
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
                        <h6 class="text-white text-capitalize m-0">Tambah Aset</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Jenis Aset</label>
                            <input type="text" class="form-control" disabled value="<?= $result['jenis_aset']; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori Aset</label>
                            <input type="text" class="form-control" disabled value="<?= $result['kategori_aset']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control p-2" name="nama" id="nama" autocomplete="off" required>
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
                            <a href="?h=aset&id_jenis_aset=<?= $_GET['id_jenis_aset'] ?>&id_kategori_aset=<?= $_GET['id_kategori_aset'] ?>" class="btn btn-secondary">Kembali</a>
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