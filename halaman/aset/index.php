<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Data Aset</h6>
                        <a href="?h=tambah_aset&id_kategori_aset=<?= $_GET['id_kategori_aset']; ?>&id_jenis_aset=<?= $_GET['id_jenis_aset']; ?>" class="btn btn-dark m-0">Tambah</a>
                    </div>
                </div>

                <div class="card-body pb-3">
                    <div class="table-responsive p-0">
                        <table id="datatable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 small-td">No</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Rusak</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Hilang</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Dipinjam</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Total</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                                SELECT 
                                    a.*,
                                    (SELECT COUNT(*) FROM aset_masuk ar WHERE ar.id_aset=a.id) masuk,
                                    (SELECT COUNT(*) FROM aset_rusak ar WHERE ar.id_aset=a.id) rusak,
                                    (SELECT COUNT(*) FROM aset_hilang ah WHERE ah.id_aset=a.id) hilang,
                                    (SELECT COUNT(*) FROM peminjaman_aset ad WHERE ad.id_aset=a.id AND ad.id NOT IN (SELECT id_peminjaman_aset FROM pengembalian_aset)) dipinjam
                                FROM 
                                    aset a
                                WHERE 
                                    a.id_kategori_aset=" . $_GET['id_kategori_aset'] . "
                            ";
                            $result = $mysqli->query($q);
                            $no = 1;
                            ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center">
                                            <p class="text-secondary mb-0"><?= $no++; ?></p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-secondary mb-0"><?= $row['nama']; ?></p>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm m-0 btn-danger text-white">
                                                <span class="badge badge-sm bg-gradient-danger p-2">
                                                    <?= $row['rusak']; ?>
                                                </span>
                                                Tambah
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm m-0 btn-danger text-white">
                                                <span class="badge badge-sm bg-gradient-danger p-2">
                                                    <?= $row['hilang']; ?>
                                                </span>
                                                Tambah
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-secondary mb-0"><?= $row['dipinjam']; ?></p>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm m-0 btn-info text-white">
                                                <span class="badge badge-sm bg-gradient-info p-2">
                                                    <?= $row['jumlah'] + $row['masuk'] - $row['rusak'] - $row['hilang'] - $row['dipinjam']; ?>
                                                </span>
                                                Tambah
                                            </a>
                                        </td>
                                        <td class="small-td">
                                            <a href="?h=edit_aset&id=<?= $row['id'] ?>&id_jenis_aset=<?= $_GET['id_jenis_aset'] ?>&id_kategori_aset=<?= $_GET['id_kategori_aset'] ?>" class="btn btn-sm btn-warning text-white m-0">Edit</a>
                                            <a href="?h=hapus_aset&id=<?= $row['id'] ?>&id_jenis_aset=<?= $_GET['id_jenis_aset'] ?>&id_kategori_aset=<?= $_GET['id_kategori_aset'] ?>" class="btn btn-sm btn-danger text-white m-0">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>