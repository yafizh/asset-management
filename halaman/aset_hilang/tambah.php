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

    try {
        $mysqli->begin_transaction();

        $q = "
            SELECT 
            (
                (SELECT IFNULL(SUM(jumlah),0) FROM aset_masuk WHERE id_aset=".$_GET['id'].")
                -
                (SELECT IFNULL(SUM(jumlah),0) FROM aset_rusak WHERE id_aset=".$_GET['id'].")
                -
                (SELECT IFNULL(SUM(jumlah),0) FROM aset_hilang WHERE id_aset=".$_GET['id'].")
            ) AS jumlah 
        ";

        $jumlah_aset_sekarang = $mysqli->query($q)->fetch_assoc()['jumlah'];
        
        if ($jumlah > $jumlah_aset_sekarang) {
            echo "<script>alert('Tidak dapat melebihi jumlah aset sekarang!')</script>";
        } else {
            $q = "
                INSERT INTO aset_hilang (
                    id_pengguna, 
                    id_aset, 
                    tanggal, 
                    jumlah, 
                    keterangan 
                ) VALUES (
                    " . $_SESSION['user']['id'] . ",
                    '$id',
                    '$tanggal',
                    '$jumlah',
                    '$keterangan'
                )";
            $mysqli->query($q);

            $mysqli->commit();
            echo "<script>alert('Pelaporan Aset Hilang Berhasil!')</script>";
            echo "<script>location.href = '?h=aset&id_jenis_aset=" . $_GET['id_jenis_aset'] . "&id_kategori_aset=" . $_GET['id_kategori_aset'] . "';</script>";
        }
    } catch (\Throwable $e) {
        echo "<script>alert('Pelaporan Aset Hilang Gagal!')</script>";
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
                        <h6 class="text-white text-capitalize m-0">Tambah Aset Hilang</h6>
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
                            <input type="number" class="form-control p-2" value="1" min="1" required name="jumlah" id="jumlah">
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