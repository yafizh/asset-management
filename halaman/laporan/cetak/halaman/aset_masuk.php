<h4 class="text-center my-3">Laporan Penambahan Aset</h4>
<section class="mb-3 px-3">
    <strong>
        <span style="width: 150px; display: inline-block;">Filter Tanggal</span>
        <span>: Tanggal Penambahan Aset</span>
    </strong>
    <br>
    <span style="width: 150px; display: inline-block;">Dari Tanggal</span>
    <span>: <?= tanggalIndonesia($_POST['dari_tanggal']); ?></span>
    <br>
    <span style="width: 150px; display: inline-block;">Sampai Tanggal</span>
    <span>: <?= tanggalIndonesia($_POST['sampai_tanggal']); ?></span>
    <br>
    <?php
    $result = $mysqli->query("SELECT * FROM jenis_aset WHERE id=" . $_POST['jenis_aset']);
    $data = $result->fetch_assoc();
    ?>
    <span style="width: 150px; display: inline-block;">Jenis Aset</span>
    <span>: <?= $data['nama']; ?></span>
    <br>
    <?php
    $result = $mysqli->query("SELECT * FROM kategori_aset WHERE id=" . $_POST['kategori_aset']);
    $data = $result->fetch_assoc();
    ?>
    <span style="width: 150px; display: inline-block;">Kategori Aset</span>
    <span>: <?= $data['nama']; ?></span>
</section>
<main class="px-3">
    <table class="table table-striped table-bordered">
        <thead class="text-center">
            <tr>
                <th class="text-center small-td">No</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Petugas Yang Melapor</th>
                <th class="text-center">Nama Aset</th>
                <th class="text-center">Jumlah</th>
            </tr>
        </thead>
        <?php
        $q = "
        SELECT
            pegawai.nama nama_pegawai,
            a.nama nama_aset,
            ah.jumlah, 
            ah.tanggal  
        FROM 
            aset_masuk ah  
        INNER JOIN 
            aset a
        ON 
            a.id=ah.id_aset 
        INNER JOIN 
            pengguna 
        ON 
            pengguna.id=ah.id_pengguna 
        LEFT JOIN 
            pegawai 
        ON 
            pegawai.id_pengguna=pengguna.id 
        WHERE 
            (
                ah.tanggal >= '" . $_POST['dari_tanggal'] . "' 
                AND 
                ah.tanggal <= '" . $_POST['sampai_tanggal'] . "' 
            ) 
            AND 
            a.id_kategori_aset='" . $_POST['kategori_aset'] . "' 
        ORDER BY 
            ah.tanggal DESC 
        ";

        $result = $mysqli->query($q);
        $no = 1;
        ?>
        <tbody>
            <?php if ($result->num_rows) : ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td style="vertical-align: middle;" class="text-center small-td"><?= $no++; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= tanggalIndonesia($row['tanggal']); ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['nama_pegawai']; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['nama_aset']; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['jumlah']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5" class="text-center">Data Kosong</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>