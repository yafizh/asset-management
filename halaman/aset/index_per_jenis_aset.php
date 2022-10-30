<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <?php
                $q = "SELECT nama FROM jenis_aset WHERE id=" . $_GET['id'];
                $result = $mysqli->query($q);
                ?>
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Data Aset <strong><?= $result->fetch_assoc()['nama']; ?></strong></h6>
                        <a href="?h=tambah_aset&id_jenis_aset=<?= $_GET['id']; ?>" class="btn btn-dark m-0">Tambah</a>
                    </div>
                </div>

                <div class="card-body pb-3">
                    <div class="table-responsive p-0">
                        <table id="datatable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 small-td">No</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Keterangan</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 small-td">Status</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                                SELECT 
                                    a.id,
                                    a.nama,  
                                    a.keterangan,  
                                    IFNULL(
                                        (SELECT ar.id FROM aset_rusak AS ar WHERE (ar.id_aset=a.id)), 
                                        FALSE 
                                    ) AS rusak,
                                    IFNULL(
                                        (SELECT ah.id FROM aset_hilang AS ah WHERE (ah.id_aset=a.id)), 
                                        FALSE 
                                    ) AS hilang, 
                                    IFNULL(
                                        (SELECT plhra.id FROM pemeliharaan_aset AS plhra WHERE plhra.id_aset=a.id AND plhra.tanggal_selesai IS NULL),
                                        FALSE 
                                    ) AS sedang_pemeliharaan,
                                    IFNULL(
                                        (SELECT pa.id FROM peminjaman_aset AS pa WHERE (pa.id_aset=a.id) AND pa.status = 1), 
                                        FALSE
                                    ) AS sedang_dipesan,
                                    IFNULL(
                                        (SELECT pa.id FROM peminjaman_aset AS pa WHERE (pa.id_aset=a.id) AND pa.status BETWEEN 2 AND 5), 
                                        FALSE 
                                    ) AS sedang_dipinjam 
                                FROM 
                                    aset AS a 
                                WHERE 
                                    id_jenis_aset=" . $_GET['id'] . "
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
                                            <p class="text-secondary mb-0"><?= $row['keterangan']; ?></p>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($row['rusak']) : ?>
                                                <span class="badge badge-sm bg-gradient-danger p-2">Rusak</span>
                                            <?php elseif ($row['hilang']) : ?>
                                                <span class="badge badge-sm bg-gradient-danger p-2">Hilang</span>
                                            <?php elseif ($row['sedang_pemeliharaan']) : ?>
                                                <span class="badge badge-sm bg-gradient-info p-2">Dalam Masa Pemeliharaan</span>
                                            <?php elseif ($row['sedang_dipesan']) : ?>
                                                <span class="badge badge-sm bg-gradient-info p-2">Dipesan</span>
                                            <?php elseif ($row['sedang_dipinjam']) : ?>
                                                <span class="badge badge-sm bg-gradient-info p-2">Sedang Dipinjam</span>
                                            <?php else : ?>
                                                <span class="badge badge-sm bg-gradient-success p-2">Tersedia</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="small-td">
                                            <a href="?h=detail_aset&id=<?= $row['id'] ?>" class="btn btn-sm btn-info text-white m-0">Lihat</a>
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