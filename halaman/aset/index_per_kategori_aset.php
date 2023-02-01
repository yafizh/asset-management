<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <?php
                $q = "SELECT nama FROM kategori_aset WHERE id=" . $_GET['id'];
                $result = $mysqli->query($q);
                ?>
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Data Aset <strong><?= $result->fetch_assoc()['nama']; ?></strong></h6>
                        <a href="?h=tambah_aset&id_kategori_aset=<?= $_GET['id']; ?>" class="btn btn-dark m-0">Tambah</a>
                    </div>
                </div>

                <div class="card-body pb-3">
                    <div class="table-responsive p-0">
                        <table id="datatable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 small-td">No</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 small-td">Status</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <?php
                            $result = $mysqli->query("SELECT * FROM aset WHERE id_kategori_aset=" . $_GET['id']);
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
                                            <?php if ($row['status'] == 1) : ?>
                                                <span class="badge badge-sm bg-gradient-success p-2">Tersedia</span>
                                            <?php elseif ($row['status'] == 2) : ?>
                                                <span class="badge badge-sm bg-gradient-danger p-2">Rusak</span>
                                            <?php elseif ($row['status'] == 3) : ?>
                                                <span class="badge badge-sm bg-gradient-danger p-2">Hilang</span>
                                            <?php elseif ($row['status'] == 4) : ?>
                                                <span class="badge badge-sm bg-gradient-info p-2">Dalam Masa Pemeliharaan</span>
                                            <?php elseif ($row['status'] == 5) : ?>
                                                <span class="badge badge-sm bg-gradient-info p-2">Sedang Dipinjam</span>
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