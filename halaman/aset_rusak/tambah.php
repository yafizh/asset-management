<?php
$q = "
SELECT 
    ja.nama jenis_aset,
    ka.nama kategori_aset,
    a.* 
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
    $id = $mysqli->real_escape_string($_GET['id']);
    $tanggal = $mysqli->real_escape_string($_POST['tanggal']);
    $jumlah = $mysqli->real_escape_string($_POST['jumlah']);
    $keterangan = $mysqli->real_escape_string($_POST['keterangan']);
    $status = $mysqli->real_escape_string($_POST['status']);

    try {
        $mysqli->begin_transaction();

        $jumlah_aset_sekarang = $mysqli->query("SELECT jumlah FROM aset WHERE id=" . $_GET['id'])->fetch_assoc()['jumlah'];
        if ($jumlah > $jumlah_aset_sekarang) {
            echo "<script>alert('Tidak dapat melebihi jumlah aset sekarang!')</script>";
        } else {
            $q = "
                INSERT INTO aset_rusak (
                    id_pengguna, 
                    id_aset, 
                    tanggal, 
                    jumlah, 
                    status, 
                    keterangan 
                ) VALUES (
                    " . $_SESSION['user']['id'] . ",
                    '$id',
                    '$tanggal',
                    '$jumlah',
                    '$status',
                    '$keterangan'
                )";
            $mysqli->query($q);

            $mysqli->commit();
            echo "<script>alert('Pelaporan Aset Rusak Berhasil!')</script>";
            echo "<script>location.href = '?h=aset&id_jenis_aset=" . $_GET['id_jenis_aset'] . "&id_kategori_aset=" . $_GET['id_kategori_aset'] . "';</script>";
        }
    } catch (\Throwable $e) {
        echo "<script>alert('Pelaporan Aset Rusak Gagal!')</script>";
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
                    <div class="bg-gradient-danger shadow-danger border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Tambah Aset Rusak</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control p-2" name="tanggal" id="tanggal" required value="<?= Date("Y-m-d"); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control p-2" disabled value="<?= $data['nama'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="text" class="form-control p-2" value="1" min="1" required name="jumlah" id="jumlah">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Kondisi Rusak</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="1">Rusak Biasa</option>
                                <option value="2">Rusak Parah (Dimusnahkan)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="5" class="form-control" required autocomplete="off" autofocus></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="?h=aset&id_jenis_aset=<?= $_GET['id_jenis_aset']; ?>&id_kategori_aset=<?= $_GET['id_kategori_aset']; ?>" class="btn btn-secondary">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-success" onclick="return confirm('Yakin?')">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>