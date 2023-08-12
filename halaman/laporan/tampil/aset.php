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
                            <?php $result = $mysqli->query("SELECT * FROM jenis_aset"); ?>
                            <label for="jenis_aset">Jenis Aset</label>
                            <select name="jenis_aset" id="jenis_aset" class="form-control">
                                <option value="" selected>Semua Jenis Aset</option>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <option value="<?= $row['id']; ?>" <?= (($_POST['jenis_aset'] ?? '') == $row['id'] ? 'selected' : '') ?>><?= $row['nama']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kategori_aset">Kategori Aset</label>
                            <select name="kategori_aset" id="kategori_aset" class="form-control">
                                <option value="" selected>Semua Kategori Aset</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script>
            const id_kategori_aset = JSON.parse('<?= json_encode($_POST['kategori_aset'] ?? 0); ?>');
            const kategori_aset = JSON.parse('<?= json_encode($kategori_aset); ?>');
            document.getElementById('jenis_aset').addEventListener('change', function() {
                document.getElementById('kategori_aset').innerHTML = '<option value="" selected>Semua Kategori Aset</option>';
                kategori_aset[this.value].forEach(element => {
                    document.getElementById('kategori_aset').insertAdjacentHTML('beforeend', `
                        <option ${id_kategori_aset == element.id ? 'selected' : ''} value="${element.id}">${element.nama}</option>
                    `);
                });
            });
            document.getElementById('jenis_aset').dispatchEvent(new Event('change'));
        </script>
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Laporan Aset</h6>
                        <form action="halaman/laporan/cetak/index.php?h=aset" method="POST" target="_blank">
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
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 small-td">No</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Tanggal Masuk</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Nama Aset</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Lokasi</th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                                SELECT
                                    a.* 
                                FROM 
                                    aset AS a  
                                INNER JOIN 
                                    kategori_aset ka 
                                ON 
                                    ka.id=a.id_kategori_aset 
                                WHERE 
                                    1=1 
                                ";

                            if (!empty($_POST['jenis_aset'] ?? '')) {
                                $q .= " AND ka.id_jenis_aset='" . $_POST['jenis_aset'] . "'";
                            }

                            if (!empty($_POST['kategori_aset'] ?? '')) {
                                $q .= " AND a.id_kategori_aset='" . $_POST['kategori_aset'] . "'";
                            }

                            $q .= " ORDER BY a.tanggal DESC";
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
                                                <p class="text-secondary mb-0"><?= tanggalIndonesia($row['tanggal']); ?></p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= $row['nama']; ?></p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-secondary mb-0"><?= $row['lokasi']; ?></p>
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