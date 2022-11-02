<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<?php
$q = "
    SELECT 
        ja.nama AS jenis_aset,
        sa.nama AS sifat_aset,
        a.*,
        (SELECT COUNT(a.id) FROM aset AS a INNER JOIN aset_rusak AS ar ON a.id=ar.id_aset) AS rusak, 
        (SELECT COUNT(a.id) FROM aset AS a INNER JOIN aset_hilang AS ah ON a.id=ah.id_aset) AS hilang, 
        (SELECT COUNT(a.id) FROM aset AS a INNER JOIN pemeliharaan_aset AS plhra ON a.id=plhra.id_aset WHERE plhra.tanggal_selesai IS NULL) AS sedang_pemeliharaan, 
        (SELECT COUNT(a.id) FROM aset AS a INNER JOIN peminjaman_aset AS pa ON a.id=pa.id_aset WHERE pa.status BETWEEN 2 AND 5) AS sedang_dipinjam, 
        (SELECT COUNT(a.id) FROM aset AS a INNER JOIN peminjaman_aset AS pa ON a.id=pa.id_aset WHERE pa.status = 1) AS sedang_dipesan  
    FROM 
        aset AS a 
    INNER JOIN 
        jenis_aset AS ja 
    ON 
        ja.id=a.id_jenis_aset 
    INNER JOIN 
        sifat_aset AS sa 
    ON 
        sa.id=a.id_sifat_aset 
    WHERE 
        a.id=" . $_GET['id'];
$result = $mysqli->query($q);
$data = $result->fetch_assoc();
?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-3">
            <div class="col-12 mb-5">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize m-0">Scan QR Code Aset</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div style="aspect-ratio: 1 / 1;">
                            <div id="reader" style="height: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function onScanSuccess(decodedText, decodedResult) {
                    // handle the scanned code as you like, for example:
                    console.log(`Code matched = ${decodedText}`, decodedResult);
                }

                function onScanFailure(error) {
                    // handle scan failure, usually better to ignore and keep scanning.
                    // for example:
                    console.warn(`Code scan error = ${error}`);
                }

                let html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader", {
                        fps: 10,
                        qrbox: {
                            width: 250,
                            height: 250
                        }
                    },
                    /* verbose= */
                    false);
                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                console.log(html5QrcodeScanner);
            </script>
            <div class="col-12 mb-5">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize m-0">Gambar Aset</h6>
                            <button class="btn btn-dark m-0" data-bs-toggle="modal" data-bs-target="#detailGambarModal">Lihat</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <img src="<?= $data['foto']; ?>" class="rounded" style="width: 100%; aspect-ratio: 16 / 9; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
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
                            <div class="mb-3">
                                <label class="form-label">Jenis Aset</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['jenis_aset'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sifat Aset</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['sifat_aset'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['nama'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Masuk</label>
                                <input type="text" class="form-control p-2" disabled value="<?= tanggalIndonesiaString($data['tanggal_masuk']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control p-2" rows="5" disabled><?= $data['keterangan'] ?></textarea>
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
                                </div>
                            </div>
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="d-flex align-items-center flex-grow-1">
                                    <a href="?h=aset_per_jenis_aset&id=<?= $data['id_jenis_aset']; ?>" class="btn btn-secondary">Kembali</a>
                                </div>
                                <div class="d-flex justify-content-end align-items-center flex-wrap gap-1 flex-grow-1">
                                    <?php if ($data['rusak']) : ?>
                                        <div class="alert alert-danger text-white" role="alert">
                                            Aset Sedang Dalam Keadaan <strong>Rusak</strong>
                                        </div>
                                    <?php elseif ($data['hilang']) : ?>
                                        <div class="alert alert-danger text-white" role="alert">
                                            Aset Sedang Dalam Keadaan <strong>Hilang</strong>
                                        </div>
                                    <?php elseif ($data['sedang_pemeliharaan']) : ?>
                                        <div class="alert alert-warning text-white" role="alert">
                                            Aset Sedang Dalam Keadaan <strong>Masa Pemeliharaan</strong>
                                        </div>
                                    <?php elseif ($data['sedang_dipesan']) : ?>
                                        <div class="alert alert-info text-white" role="alert">
                                            Aset Sedang Dalam Keadaan <strong>Dipesan</strong>. Tolak terlebih dahulu pemesanan untuk melakukan aksi lainnya.
                                        </div>
                                    <?php elseif ($data['sedang_dipinjam']) : ?>
                                        <div class="alert alert-info text-white" role="alert">
                                            Aset Sedang Dalam Keadaan <strong>Dipinjam</strong>. Tunggu pengembalian terlebih dahulu untuk melakukan aksi lainnya.
                                        </div>
                                    <?php else : ?>
                                        <button type="submit" class="btn btn-success" onclick="return confirm('Yakin?')">Ajukan Peminjaman</butt>
                                        <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade animate__animated animate__zoomIn" id="detailGambarModal" tabindex="-1" aria-labelledby="detailGambarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-0">
                <img src="<?= $data['foto']; ?>" style="width: 100%; object-fit: cover;">
            </div>
        </div>
    </div>
</div>