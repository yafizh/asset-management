<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Data Pemeliharaan Aset</h6>
                    </div>
                </div>
                <div class="card-body pb-3">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 small-td">No</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Jenis Aset</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Sedang Dalam Pemeliharaan</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Telah Menjalani Pemeliharaan</th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                                SELECT 
                                    ja.id, 
                                    ja.nama, 
                                    (SELECT COUNT(a.id) FROM aset AS a WHERE ja.id=a.id AND a.id IN (SELECT id_aset FROM pemeliharaan_aset WHERE tanggal_selesai IS NULL)) AS sedang_dalam_pemeliharaan, 
                                    (SELECT COUNT(a.id) FROM aset AS a WHERE ja.id=a.id AND a.id IN (SELECT id_aset FROM pemeliharaan_aset WHERE tanggal_selesai IS NOT NULL)) AS telah_menjalani_pemeliharaan   
                                FROM 
                                    jenis_aset AS ja
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
                                        <td class="align-middle text-center">
                                            <a href="?h=aset_sedang_pemeliharaan&id=<?= $row['id']; ?>" class="btn btn-sm m-0 btn-info text-white">
                                                <span class="badge badge-sm bg-gradient-info p-2">
                                                    <?= $row['sedang_dalam_pemeliharaan']; ?>
                                                </span>
                                                Lihat
                                            </a>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="?h=aset_selesai_pemeliharaan&id=<?= $row['id']; ?>" class="btn btn-sm m-0 btn-success text-white">
                                                <span class="badge badge-sm bg-gradient-success p-2">
                                                    <?= $row['telah_menjalani_pemeliharaan']; ?>
                                                </span>
                                                Lihat
                                            </a>
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