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
}

if (isset($_POST['submit'])) {
    $id = $mysqli->real_escape_string($_POST['id']);
    $alasan_peminjaman = $mysqli->real_escape_string($_POST['alasan_peminjaman']);

    $q = "
    INSERT INTO peminjaman_aset (
        id_pegawai,
        id_aset,
        alasan_peminjaman,
        timestamp_pengajuan,
        status 
    ) VALUES (
        '" . $_SESSION['user']['id'] . "',
        '$id',
        '$alasan_peminjaman',
        '" . Date('Y-m-d H:i:s') . "',
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
?>
<div class="container-fluid">
    <div id="scanner" style="width: 100%; height: 100%;" class="<?= isset($_GET['id']) ? 'd-none' : ''; ?>">
        <div class="div mb-3">
            <label for="">Kamera</label>
            <select id="camera" class="form-control">
                <option value="" disabled selected>Pilih Kamera Lainnya</option>
            </select>
        </div>
        <video style="width: 100%; height: 100%;"></video>
    </div>
    <div id="form-peminjaman" class="row justify-content-center <?= $_GET['id'] ?? 'd-none' ?>">
        <div class="col-12 col-md-3" id="aset">
            <div class="col-12 mb-5">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize m-0">Gambar Aset</h6>
                            <button class="btn btn-dark m-0" data-bs-toggle="modal" data-bs-target="#detailGambarModal">Lihat</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <img id="foto" src="<?= $data['foto'] ?? 'assets/img/no-image.jpg'; ?>" class="rounded" style="width: 100%; aspect-ratio: 16 / 9; object-fit: cover;">
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
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Kategori Aset</label>
                                    <input type="text" class="form-control p-2" disabled id="kategori_aset" value="<?= $data['kategori_aset'] ?? ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control p-2" disabled id="nama" value="<?= $data['nama'] ?? ''; ?>">
                                </div>
                                <div class="mb-3" id="detail">
                                    <label class="form-label">Detail</label>
                                    <?php foreach ($data['detail'] as $key => $value) : ?>
                                        <div class="row ps-1 mb-2">
                                            <div class="col-auto" style="width: 120px;"><?= $value['kolom']; ?></div>
                                            <div class="col-auto">: <?= $value['nilai']; ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal</label>
                                    <input type="text" class="form-control" value="<?= tanggalIndonesiaString(Date("Y-m-d")); ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="alasan_peminjaman" class="form-label">Alasan Peminjaman</label>
                                    <textarea name="alasan_peminjaman" id="alasan_peminjaman" class="form-control" autofocus></textarea>
                                </div>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex align-items-center flex-grow-1">
                                        <a href="?h=aset_per_jenis_aset&id=<?= $data['id_jenis_aset']; ?>" class="btn btn-secondary">Kembali</a>
                                    </div>
                                    <div class="d-flex justify-content-end align-items-center flex-wrap gap-1 flex-grow-1">
                                        <input id="id_aset" type="text" name="id" value="<?= $data['id'] ?? ''; ?>" hidden>
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
<!-- Modal -->
<div class="modal fade animate__animated animate__zoomIn" id="detailGambarModal" tabindex="-1" aria-labelledby="detailGambarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-0">
                <img id="modal_foto" src="<?= $data['foto'] ?? ''; ?>" style="width: 100%; object-fit: cover;">
            </div>
        </div>
    </div>
</div>
<script type="module">
    import QrScanner from './assets/js/plugins/qr-scanner/qr-scanner.min.js';

    const id_aset = document.getElementById('id_aset');
    const nama = document.getElementById('nama');
    const kategori_aset = document.getElementById('kategori_aset');
    const detail = document.getElementById('detail');
    const foto = document.getElementById('foto');
    const modal_foto = document.getElementById('modal_foto');


    const setResult = (result) => {
        const data = JSON.parse(result.data);
        const detail_data = data.detail;
        id_aset.value = data.id;
        nama.value = data.nama;
        kategori_aset.value = data.kategori_aset;
        foto.setAttribute('src', data.foto);
        modal_foto.setAttribute('src', data.foto);
        detail.innerText = '';
        for (let i = 0; i < Object.values(detail_data).length; i++) {
            detail.insertAdjacentHTML('beforeend',
                `
                <div class="row ps-1 mb-2">
                    <div class="col-auto" style="width: 120px;">${Object.values(detail_data)[i]["kolom"]}</div>
                    <div class="col-auto">: ${Object.values(detail_data)[i]["nilai"]}</div>
                </div>
            `
            );
        }
        document.getElementById('form-peminjaman').classList.remove('d-none');
        document.getElementById('scanner').classList.add('d-none');
        scanner.stop();
    }


    const scanner = new QrScanner(document.querySelector('video'), result => setResult(result), {
        highlightScanRegion: true,
        highlightCodeOutline: true,
    });
    <?php if (!isset($_GET['id'])) : ?>
        scanner.start();
    <?php endif; ?>
        (async () => {
            const selectCamera = document.getElementById('camera');
            for (const camera of await QrScanner.listCameras(true)) {
                const option = document.createElement('option');
                option.value = camera.id;
                option.innerText = camera.label;
                selectCamera.append(option);
            }
            selectCamera.addEventListener('change', function() {
                scanner.setCamera(this.value);
            });
        })();
</script>