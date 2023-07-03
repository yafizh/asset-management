<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Data Aset</h6>
                    </div>
                </div>

                <div class="card-body pb-3">
                    <div class="table-responsive p-0">
                        <table id="datatable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 small-td">No</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Jumlah Tersedia</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                                SELECT 
                                    a.*,
                                    (SELECT SUM(jumlah) FROM aset_masuk ar WHERE ar.id_aset=a.id) masuk,
                                    (SELECT SUM(jumlah) FROM aset_rusak ar WHERE ar.id_aset=a.id) rusak,
                                    (SELECT SUM(jumlah) FROM aset_hilang ah WHERE ah.id_aset=a.id) hilang,
                                    (SELECT SUM(jumlah) FROM peminjaman_aset pa WHERE pa.id_aset=a.id AND pa.status != 2 AND pa.id NOT IN (SELECT id_peminjaman_aset FROM pengembalian_aset WHERE pengembalian_aset.id_peminjaman_aset=pa.id)) peminjaman
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
                                            <p class="text-secondary mb-0"><?= $row['masuk'] - $row['rusak'] - $row['hilang'] - $row['peminjaman']; ?></p>
                                        </td>
                                        <td class="small-td">
                                            <a href="?h=pengajuan_peminjaman&id=<?= $row['id'] ?>&id_jenis_aset=<?= $_GET['id_jenis_aset'] ?>&id_kategori_aset=<?= $_GET['id_kategori_aset'] ?>" class="btn btn-sm btn-success text-white m-0">Ajukan Peminjaman</a>
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