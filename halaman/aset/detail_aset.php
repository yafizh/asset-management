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
$data['detail'] = $mysqli->query("SELECT * FROM detail_aset WHERE id_aset=" . $_GET['id'])->fetch_all(MYSQLI_ASSOC);
?>
<div class="container-fluid py-4">
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
                            <div class="mb-3">
                                <label class="form-label">Jenis Aset</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['jenis_aset'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori Aset</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['kategori_aset'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control p-2" disabled value="<?= $data['nama'] ?>">
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
                                    <a href="?h=aset&id_jenis_aset=<?= $_GET['id_jenis_aset']; ?>&id_kategori_aset=<?= $_GET['id_kategori_aset']; ?>" class="btn btn-secondary">Kembali</a>
                                </div>
                                <div class="d-flex justify-content-end align-items-center flex-wrap gap-1 flex-grow-1">
                                    <a href="?h=edit_aset&id=<?= $data['id'] ?>&id_jenis_aset=<?= $_GET['id_jenis_aset'] ?>&id_kategori_aset=<?= $_GET['id_kategori_aset'] ?>" class="btn btn-warning text-white">Edit</a>
                                    <a href="?h=hapus_aset&id=<?= $data['id']; ?>&id_jenis_aset=<?= $_GET['id_jenis_aset'] ?>&id_kategori_aset=<?= $_GET['id_kategori_aset'] ?>" class="btn btn-danger" onclick="return confirm('Yakin?')">Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>