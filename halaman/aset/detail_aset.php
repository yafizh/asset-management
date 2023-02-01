<?php
$q = "
    SELECT 
        ja.nama jenis_aset,
        ka.nama kategori_aset,
        a.*
    FROM 
        aset a 
    INNER JOIN 
        jenis_aset ja 
    ON 
        ja.id=a.id_jenis_aset 
    INNER JOIN 
        kategori_aset ka 
    ON 
        ka.id=a.id_kategori_aset 
    WHERE 
        a.id=" . $_GET['id'];
$result = $mysqli->query($q);
$data = $result->fetch_assoc();
$data['detail'] = $mysqli->query("SELECT * FROM detail_aset WHERE id_aset=" . $_GET['id'])->fetch_all(MYSQLI_ASSOC);
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 col-md-4">
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
            <div class="col-12 mb-5">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize m-0">QR Code Aset</h6>
                            <button id="cetak" class="btn btn-dark m-0">Cetak</a>
                        </div>
                    </div>
                    <style>
                        .fade-scale {
                            transform: scale(0);
                            opacity: 0;
                            -webkit-transition: all .25s linear;
                            -o-transition: all .25s linear;
                            transition: all .25s linear;
                        }

                        .fade-scale.in {
                            opacity: 1;
                            transform: scale(1);
                        }

                        #qrcode canvas {
                            height: 100% !important;
                        }
                    </style>
                    <div class="card-body">
                        <div style="aspect-ratio: 1 / 1;">
                            <div id="qrcode" style="height: 100%;"></div>
                        </div>
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
                                <input type="text" class="form-control p-2" disabled value="<?= $data['kategori_aset'] ?>">
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
                                <label class="form-label">Detail</label>
                                <?php foreach ($data['detail'] as $key => $value) : ?>
                                    <div class="row ps-1 mb-2">
                                        <div class="col-auto" style="width: 120px;"><?= $value['kolom']; ?></div>
                                        <div class="col-8">: <?= $value['nilai']; ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="d-flex justify-content-between flex-wrap mt-5">
                                <div class="d-flex align-items-center flex-grow-1">
                                    <a href="?h=aset_per_kategori_aset&id=<?= $data['id_kategori_aset']; ?>" class="btn btn-secondary">Kembali</a>
                                </div>
                                <div class="d-flex justify-content-center align-items-center flex-wrap gap-1 flex-grow-1">
                                    <?php if ($data['status'] == 1) : ?>
                                        <a href="?h=tambah_aset_rusak&id=<?= $data['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin?')">Laporkan Rusak</a>
                                        <a href="?h=tambah_aset_hilang&id=<?= $data['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin?')">Laporkan Hilang</a>
                                        <a href="?h=tambah_pemeliharaan_aset&id=<?= $data['id']; ?>" class="btn btn-warning text-white">Lakukan Pemeliharaan</a>
                                    <?php elseif ($data['status'] == 2) : ?>
                                        <div class="alert alert-danger text-white" role="alert">
                                            Aset Sedang Dalam Keadaan <strong>Rusak</strong>
                                        </div>
                                    <?php elseif ($data['status'] == 3) : ?>
                                        <div class="alert alert-danger text-white" role="alert">
                                            Aset Sedang Dalam Keadaan <strong>Hilang</strong>
                                        </div>
                                    <?php elseif ($data['status'] == 4) : ?>
                                        <div class="alert alert-warning text-white" role="alert">
                                            Aset Sedang Dalam Keadaan <strong>Masa Pemeliharaan</strong>
                                        </div>
                                    <?php elseif ($data['status'] == 5) : ?>
                                        <div class="alert alert-info text-white" role="alert">
                                            Aset Sedang Dalam Keadaan <strong>Dipinjam</strong>. Tunggu pengembalian terlebih dahulu untuk melakukan aksi lainnya.
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex justify-content-end align-items-center flex-wrap gap-1 flex-grow-1">
                                    <a href="?h=edit_aset&id=<?= $data['id']; ?>" class="btn btn-warning text-white">Edit</a>
                                    <a href="?h=hapus_aset&id=<?= $data['id']; ?>&id_jenis_aset=<?= $data['id_jenis_aset']; ?>" class="btn btn-danger" onclick="return confirm('Yakin?')">Hapus</a>
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
<script>
    const qrCode = new QRCodeStyling({
        width: 1000,
        height: 1000,
        data: JSON.stringify(<?= json_encode($data); ?>),
        image: "assets/img/favicon.png",
        backgroundOptions: {
            color: "#ffffff",
        },
        imageOptions: {
            crossOrigin: "anonymous",
            margin: 30
        },
        margin: 0
    });

    qrCode.append(document.getElementById("qrcode"));

    document.getElementById('cetak').addEventListener('click', () => {
        qrCode.download({});
    });
</script>