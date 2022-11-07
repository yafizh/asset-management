<?php
$q = "SELECT * FROM pegawai WHERE id=" . $_GET['id'];
$result = $mysqli->query($q);
$data = $result->fetch_assoc();
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize m-0">Gambar Pegawai</h6>
                                <button class="btn btn-dark m-0" data-bs-toggle="modal" data-bs-target="#detailGambarModal">Lihat</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <img src="<?= $data['foto']; ?>" class="rounded" style="width: 100%; aspect-ratio: 16 / 9; object-fit: cover;">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize m-0">Ijazah Pendidikan Terakhir</h6>
                                <a href="<?= $data['ijazah_pendidikan_terakhir']; ?>" target="_blank" class="btn btn-dark m-0">Lihat</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <iframe src="<?= $data['ijazah_pendidikan_terakhir']; ?>" class="rounded" style="width: 100%; aspect-ratio: 16 / 9; object-fit: cover;"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize m-0">SK TMT</h6>
                                <a href="<?= $data['sk_tmt']; ?>" target="_blank" class="btn btn-dark m-0">Lihat</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <iframe src="<?= $data['sk_tmt']; ?>" class="rounded" style="width: 100%; aspect-ratio: 16 / 9; object-fit: cover;"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Detail Pegawai</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">NIP</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['nip'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['nama'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="text" class="form-control p-2" disabled value="<?= tanggalIndonesia($data['tanggal_lahir']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['tempat_lahir'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['jabatan'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">TMT</label>
                                <input type="text" class="form-control p-2" disabled value="<?= tanggalIndonesia($data['tanggal_lahir']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pendidikan Terakhir</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['pendidikan_terakhir'] ?>">
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="?h=pegawai" class="btn btn-secondary">Kembali</a>
                                <div>
                                    <a href="?h=edit_pegawai&id=<?= $data['id']; ?>" class="btn btn-warning text-white">Edit</a>
                                    <a href="?h=hapus_pegawai&id=<?= $data['id']; ?>&id_pengguna=<?= $data['id_pengguna']; ?>" class="btn btn-danger" onclick="return confirm('Yakin?')">Hapus</a>
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