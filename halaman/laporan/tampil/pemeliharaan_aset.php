<div class="container-fluid py-4">
    <div class="row">
        <div class="col-3">
            <div class="card my-4">
                <form action="" method="POST">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize m-0">Filter Laporan</h6>
                            <button type="submit" class="btn btn-dark m-0">Filter</button>
                        </div>
                    </div>
                    <div class="card-body pb-3">
                        <div class="mb-3">
                            <label class="form-label" for="dari_tanggal_mulai">Dari Tanggal Mulai</label>
                            <input type="date" class="form-control p-2" name="dari_tanggal_mulai" id="dari_tanggal_mulai" value="<?= $_POST['dari_tanggal_mulai'] ?? ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="sampai_tanggal_mulai">Sampai Tanggal Mulai</label>
                            <input type="date" class="form-control p-2" name="sampai_tanggal_mulai" id="sampai_tanggal_mulai" value="<?= $_POST['sampai_tanggal_mulai'] ?? ''; ?>">
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label" for="dari_tanggal_selesai">Dari Tanggal Selesai</label>
                            <input type="date" class="form-control p-2" name="dari_tanggal_selesai" id="dari_tanggal_selesai" value="<?= $_POST['dari_tanggal_selesai'] ?? ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="sampai_tanggal_selesai">Sampai Tanggal Selesai</label>
                            <input type="date" class="form-control p-2" name="sampai_tanggal_selesai" id="sampai_tanggal_selesai" value="<?= $_POST['sampai_tanggal_selesai'] ?? ''; ?>">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-9">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Laporan Pemeliharaan Aset</h6>
                        <a target="_blank" href="halaman/cetak/aset_rusak.php?dari_tanggal_mulai=<?= $_POST['dari_tanggal_mulai'] ?? ''; ?>&sampai_tanggal_mulai=<?= $_POST['sampai_tanggal_mulai'] ?? ''; ?>&dari_tanggal_selesai=<?= $_POST['dari_tanggal_selesai'] ?? ''; ?>&sampai_tanggal_selesai=<?= $_POST['sampai_tanggal_selesai'] ?? ''; ?>" class="btn btn-dark m-0">
                            Cetak
                        </a>
                    </div>
                </div>
                <div class="card-body pb-3">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 small-td">No</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Jenis Aset</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Nama Aset</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Tangga Mulai</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Tangga Selesai</th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                                SELECT
                                    ja.nama AS jenis_aset, 
                                    a.nama, 
                                    pa.tanggal_mulai,
                                    pa.tanggal_selesai   
                                FROM 
                                    pemeliharaan_aset AS pa  
                                INNER JOIN 
                                    aset AS a
                                ON 
                                    a.id=pa.id 
                                INNER JOIN 
                                    jenis_aset AS ja  
                                ON 
                                    ja.id=a.id 
                                ";


                            if (
                                !empty($_POST['dari_tanggal_mulai'] ?? '')
                                ||
                                !empty($_POST['sampai_tanggal_mulai'] ?? '')
                                ||
                                !empty($_POST['dari_tanggal_selesai'] ?? '')
                                ||
                                !empty($_POST['sampai_tanggal_selesai'] ?? '')
                            ) {
                                $q .= " WHERE ";

                                if (!empty($_POST['dari_tanggal_mulai']) || !empty($_POST['dari_tanggal_mulai'])) {
                                    $dari_tanggal_mulai = !empty($_POST['dari_tanggal_mulai']) ? $_POST['dari_tanggal_mulai'] : Date("Y-m-d");
                                    $sampai_tanggal_mulai = !empty($_POST['sampai_tanggal_mulai']) ? $_POST['sampai_tanggal_mulai'] : Date("Y-m-d");
                                    $q .= " pa.tanggal_mulai >= '" . $dari_tanggal_mulai . "' AND pa.tanggal_mulai <= '" . $sampai_tanggal_mulai . "'";
                                }


                                if ((!empty($_POST['dari_tanggal_mulai']) || !empty($_POST['dari_tanggal_mulai'])) && (!empty($_POST['sampai_tanggal_mulai']) || !empty($_POST['sampai_tanggal_mulai'])))
                                    $q .= " AND ";

                                if (!empty($_POST['sampai_tanggal_mulai']) || !empty($_POST['sampai_tanggal_mulai'])) {
                                    $sampai_tanggal_mulai = !empty($_POST['sampai_tanggal_mulai']) ? $_POST['sampai_tanggal_mulai'] : Date("Y-m-d");
                                    $sampai_tanggal_selesai = !empty($_POST['sampai_tanggal_selesai']) ? $_POST['sampai_tanggal_selesai'] : Date("Y-m-d");
                                    $q .= " pa.tanggal_selesai >= '" . $sampai_tanggal_mulai . "' AND pa.tanggal_selesai <= '" . $sampai_tanggal_selesai . "'";
                                }
                            }

                            $q .= " ORDER BY pa.id DESC";
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
                                                <p class="text-secondary mb-0"><?= $row['jenis_aset']; ?></p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= $row['nama']; ?></p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= $row['tanggal_mulai']; ?></p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= $row['tanggal_selesai']; ?></p>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Data Kosong</td>
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