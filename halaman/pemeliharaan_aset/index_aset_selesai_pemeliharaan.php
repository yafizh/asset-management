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
                        <h6 class="text-white text-capitalize m-0">Data Aset <strong><?= $result->fetch_assoc()['nama']; ?></strong> yang Telah Selesai Pemeliharaan</h6>
                    </div>
                </div>

                <div class="card-body pb-3">
                    <div class="table-responsive p-0">
                        <table id="datatable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 small-td">No</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Tanggal Mulai</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Tanggal Selesai</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Keterangan</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                                SELECT 
                                    pa.id,
                                    a.nama,
                                    pa.tanggal_mulai,
                                    pa.tanggal_selesai,
                                    pa.keterangan 
                                FROM 
                                    pemeliharaan_aset AS pa  
                                INNER JOIN 
                                    aset AS a 
                                ON 
                                    pa.id_aset=a.id 
                                WHERE 
                                    pa.tanggal_selesai IS NOT NULL AND a.id_kategori_aset=" . $_GET['id'] . "
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
                                            <p class="text-secondary mb-0"><?= tanggalIndonesiaString($row['tanggal_mulai']); ?></p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-secondary mb-0"><?= tanggalIndonesiaString($row['tanggal_selesai']); ?></p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-secondary mb-0"><?= $row['keterangan']; ?></p>
                                        </td>
                                        <td class="small-td">
                                            <a href="?h=detail_pemeliharaan_aset&id=<?= $row['id'] ?>" class="btn btn-sm btn-info text-white m-0">Lihat</a>
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