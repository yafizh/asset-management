<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Laporan Data Jumlah Aset</h6>
                        <a href="#" class="btn btn-dark m-0">Cetak</a>
                    </div>
                </div>
                <div class="card-body pb-3">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 small-td">No</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Kategori Aset</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Rusak</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Hilang</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Tersedia</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Total</th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                                SELECT 
                                    ka.id, 
                                    ka.nama, 
                                    (SELECT COUNT(*) FROM aset a WHERE a.id_kategori_aset=ka.id AND a.status='2') rusak, 
                                    (SELECT COUNT(*) FROM aset a WHERE a.id_kategori_aset=ka.id AND a.status='3') hilang, 
                                    (SELECT COUNT(*) FROM aset a WHERE a.id_kategori_aset=ka.id AND a.status='4') sedang_pemeliharaan, 
                                    (SELECT COUNT(a.id) FROM aset a WHERE a.id_kategori_aset=ka.id AND a.status='5') sedang_dipinjam, 
                                    (SELECT COUNT(a.id) FROM aset a WHERE a.id_kategori_aset=ka.id AND a.status='1') tersedia,
                                    (SELECT COUNT(a.id) FROM aset a WHERE a.id_kategori_aset=ka.id) total 
                                FROM 
                                    kategori_aset ka
                            ";
                            $result = $mysqli->query($q);
                            $no = 1;
                            ?>
                            <tbody>
                                <?php if ($result->num_rows) : ?>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= $no++; ?></p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= $row['nama']; ?></p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?= $row['rusak']; ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?= $row['hilang']; ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?= $row['tersedia'] + $row['sedang_pemeliharaan'] + $row['sedang_dipinjam']; ?>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?= $row['total']; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Data Kosong</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>