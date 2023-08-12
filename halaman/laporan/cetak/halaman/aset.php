<h4 class="text-center my-3">Laporan Aset</h4>
<section class="mb-3 px-3">
    <?php
    if (!empty($_POST['jenis_aset'] ?? '')) {
        $result = $mysqli->query("SELECT * FROM jenis_aset WHERE id=" . $_POST['jenis_aset']);
        $data = $result->fetch_assoc();
    }
    ?>
    <span style="width: 150px; display: inline-block;">Jenis Aset</span>
    <span>: <?= !empty($_POST['jenis_aset'] ?? '') ? $data['nama'] : 'Semua Jenis Aset'; ?></span>
    <br>
    <?php
    if (!empty($_POST['kategori_aset'] ?? '')) {
        $result = $mysqli->query("SELECT * FROM kategori_aset WHERE id=" . $_POST['kategori_aset']);
        $data = $result->fetch_assoc();
    }
    ?>
    <span style="width: 150px; display: inline-block;">Kategori Aset</span>
    <span>: <?= !empty($_POST['kategori_aset'] ?? '') ? $data['nama'] : 'Semua Kategori Aset'; ?></span>
</section>
<main class="px-3">
    <table class="table table-striped table-bordered">
        <thead class="text-center">
            <tr>
                <th class="text-center small-td">No</th>
                <th class="text-center">Tanggal Masuk</th>
                <th class="text-center">Nama Aset</th>
                <th class="text-center">Lokasi</th>
            </tr>
        </thead>
        <?php
        $q = "
        SELECT
            a.* 
        FROM 
            aset_hilang ah  
        INNER JOIN 
            aset a
        ON 
            a.id=ah.id_aset 
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
                        <td style="vertical-align: middle;" class="text-center small-td"><?= $no++; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= tanggalIndonesia($row['tanggal']); ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['nama']; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['lokasi']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4" class="text-center">Data Kosong</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>