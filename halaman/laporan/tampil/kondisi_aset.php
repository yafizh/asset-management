<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-8">
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
                            <label class="form-label" for="dari_tanggal">Dari Tanggal</label>
                            <input type="date" class="form-control p-2" name="dari_tanggal" id="dari_tanggal" value="<?= $_POST['dari_tanggal'] ?? ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="sampai_tanggal">Sampai Tanggal</label>
                            <input type="date" class="form-control p-2" name="sampai_tanggal" id="sampai_tanggal" value="<?= $_POST['sampai_tanggal'] ?? ''; ?>" required>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <?php $result = $mysqli->query("SELECT * FROM jenis_aset"); ?>
                            <label for="jenis_aset">Jenis Aset</label>
                            <select name="jenis_aset" id="jenis_aset" class="form-control" required>
                                <option value="" selected disabled>Pilih Jenis Aset</option>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <option value="<?= $row['id']; ?>" <?= (($_POST['jenis_aset'] ?? '') == $row['id'] ? 'selected' : '') ?>><?= $row['nama']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kategori_aset">Kategori Aset</label>
                            <select name="kategori_aset" id="kategori_aset" class="form-control" required>
                                <option value="" selected disabled>Pilih Kategori Aset</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
        $result = $mysqli->query("SELECT * FROM jenis_aset");
        $kategori_aset = [];
        while ($row = $result->fetch_assoc()) {
            $kategori_aset[$row['id']] = [];
        }

        foreach ($kategori_aset as $key => $value) {
            $result = $mysqli->query("SELECT * FROM kategori_aset WHERE id_jenis_aset=" . $key);
            while ($row = $result->fetch_assoc()) {
                $kategori_aset[$key][] = $row;
            }
        }
        ?>
        <script>
            const id_kategori_aset = JSON.parse('<?= json_encode($_POST['kategori_aset'] ?? 0); ?>');
            const kategori_aset = JSON.parse('<?= json_encode($kategori_aset); ?>');
            document.getElementById('jenis_aset').addEventListener('change', function() {
                document.getElementById('kategori_aset').innerHTML = '<option value="" selected disabled>Pilih Kategori Aset</option>';
                kategori_aset[this.value].forEach(element => {
                    document.getElementById('kategori_aset').insertAdjacentHTML('beforeend', `
                        <option ${id_kategori_aset == element.id ? 'selected' : ''} value="${element.id}">${element.nama}</option>
                    `);
                });
            });
            document.getElementById('jenis_aset').dispatchEvent(new Event('change'));
        </script>
        <?php if (isset($_POST['dari_tanggal'])) : ?>
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize m-0">Laporan Kondisi Aset</h6>
                            <form action="halaman/laporan/cetak/index.php?h=kondisi_aset" method="POST" target="_blank">
                                <input type="text" hidden name="dari_tanggal" value="<?= $_POST['dari_tanggal'] ?? ''; ?>">
                                <input type="text" hidden name="sampai_tanggal" value="<?= $_POST['sampai_tanggal'] ?? ''; ?>">
                                <input type="text" hidden name="jenis_aset" value="<?= $_POST['jenis_aset'] ?? ''; ?>">
                                <input type="text" hidden name="kategori_aset" value="<?= $_POST['kategori_aset'] ?? ''; ?>">
                                <button type="submit" class="btn btn-dark m-0">Cetak</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body pb-3">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 small-td" rowspan="2">No</th>
                                        <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7" rowspan="2">Nama Aset</th>
                                        <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7" colspan="4">Kondisi</th>
                                    </tr>
                                    <tr>
                                        <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Baik</th>
                                        <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Hilang</th>
                                        <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Rusak</th>
                                        <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Dimusnahkan</th>
                                    </tr>
                                </thead>
                                <?php
                                $q = "
                                SELECT
                                    a.nama,
                                    (
                                        SELECT 
                                            SUM(jumlah) 
                                        FROM 
                                            aset_masuk am 
                                        WHERE 
                                            (
                                                am.tanggal >= '" . $_POST['dari_tanggal'] . "' 
                                                AND 
                                                am.tanggal <= '" . $_POST['sampai_tanggal'] . "' 
                                            )
                                            AND 
                                            am.id_aset=a.id
                                    ) masuk, 
                                    (
                                        SELECT 
                                            SUM(jumlah) 
                                        FROM 
                                            aset_rusak am 
                                        WHERE 
                                            (
                                                am.tanggal >= '" . $_POST['dari_tanggal'] . "' 
                                                AND 
                                                am.tanggal <= '" . $_POST['sampai_tanggal'] . "'
                                            ) 
                                            AND 
                                            am.status=1 
                                            AND 
                                            am.id_aset=a.id
                                    ) rusak, 
                                    (
                                        SELECT 
                                            SUM(jumlah) 
                                        FROM 
                                            aset_rusak am 
                                        WHERE 
                                            (
                                                am.tanggal >= '" . $_POST['dari_tanggal'] . "' 
                                                AND 
                                                am.tanggal <= '" . $_POST['sampai_tanggal'] . "'
                                            ) 
                                            AND 
                                            am.status=2 
                                            AND 
                                            am.id_aset=a.id
                                    ) dimusnahkan,
                                    (
                                        SELECT 
                                            SUM(jumlah) 
                                        FROM 
                                            aset_hilang am 
                                        WHERE 
                                            (    
                                                am.tanggal >= '" . $_POST['dari_tanggal'] . "' 
                                                AND 
                                                am.tanggal <= '" . $_POST['sampai_tanggal'] . "'
                                            )
                                            AND 
                                            am.id_aset=a.id 
                                    ) hilang 
                                FROM 
                                    aset a 
                                WHERE 
                                    a.id_kategori_aset='" . $_POST['kategori_aset'] . "' 
                                ORDER BY 
                                    a.nama 
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
                                                <td class="text-center">
                                                    <p class="text-secondary mb-0"><?= $row['hilang'] ?? 0; ?></p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-secondary mb-0"><?= $row['masuk'] ?? 0; ?></p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-secondary mb-0"><?= $row['rusak'] ?? 0; ?></p>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-secondary mb-0"><?= $row['dimusnahkan'] ?? 0; ?></p>
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
        <?php endif; ?>
    </div>
</div>