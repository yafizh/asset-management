<?php
if (isset($_GET['id'])) {
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
}

if (isset($_POST['submit'])) {
    $jumlah = $mysqli->real_escape_string($_POST['jumlah']);
    $alasan_peminjaman = $mysqli->real_escape_string($_POST['alasan_peminjaman']);

    $jumlah_aset_sekarang = $mysqli->query("SELECT jumlah FROM aset WHERE id=" . $_GET['id'])->fetch_assoc()['jumlah'];
    if ($jumlah > $jumlah_aset_sekarang) {
        echo "<script>alert('Tidak dapat melebihi jumlah aset sekarang!')</script>";
    } else {
        $q = "
            INSERT INTO peminjaman_aset (
                id_user_peminjam,
                id_aset,
                alasan,
                tanggal_waktu_pengajuan,
                jumlah,
                status 
            ) VALUES (
                '" . $_SESSION['user']['id'] . "',
                '" . $data['id'] . "',
                '$alasan_peminjaman',
                '" . Date('Y-m-d H:i:s') . "',
                '$jumlah',
                '1'
            )";

        if ($mysqli->query($q)) {
            echo "<script>alert('Pengajuan Peminjaman Aset Berhasil!')</script>";
            echo "<script>location.href = '?h=riwayat_peminjaman_aset';</script>";
        } else {
            echo "<script>alert('Pengajuan Peminjaman Aset Gagal!')</script>";
            die($mysqli->error);
        }
    }
}
?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Detail Aset</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Jenis Aset</label>
                                    <input type="text" class="form-control p-2" disabled value="<?= $data['jenis_aset']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kategori Aset</label>
                                    <input type="text" class="form-control p-2" disabled value="<?= $data['kategori_aset']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control p-2" disabled value="<?= $data['nama']; ?>">
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Peminjaman</label>
                                    <input type="text" class="form-control" value="<?= tanggalIndonesiaString(Date("Y-m-d")); ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah Yang Dipinjam</label>
                                    <input type="text" class="form-control" name="jumlah" id="jumlah" required>
                                </div>
                                <div class="mb-3">
                                    <label for="alasan_peminjaman" class="form-label">Alasan Peminjaman</label>
                                    <textarea name="alasan_peminjaman" id="alasan_peminjaman" class="form-control"></textarea>
                                </div>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex align-items-center flex-grow-1">
                                        <a href="?h=aset&id_jenis_aset=<?= $_GET['id_jenis_aset']; ?>&id_kategori_aset=<?= $_GET['id_kategori_aset']; ?>" class="btn btn-secondary">Kembali</a>
                                    </div>
                                    <div class="d-flex justify-content-end align-items-center flex-wrap gap-1 flex-grow-1">
                                        <button type="submit" name="submit" class="btn btn-success" onclick="return confirm('Yakin?')">Ajukan Peminjaman</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>