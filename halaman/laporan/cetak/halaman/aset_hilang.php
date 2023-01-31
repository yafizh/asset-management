<h4 class="text-center my-3">Laporan Aset Hilang</h4>
<?php if (!empty($_POST['dari_tanggal'] ?? '') && !empty($_POST['sampai_tanggal'] ?? '')) : ?>
    <section class="mb-3 px-3">
        <strong>
            <span style="width: 150px; display: inline-block;">Filter Tanggal</span>
            <span>: Tanggal Hilang</span>
        </strong>
        <br>
        <span style="width: 150px; display: inline-block;">Dari Tanggal</span>
        <span>: <?= tanggalIndonesia($_POST['dari_tanggal']); ?></span>
        <br>
        <span style="width: 150px; display: inline-block;">Sampai Tanggal</span>
        <span>: <?= tanggalIndonesia($_POST['sampai_tanggal']); ?></span>
    </section>
<?php endif; ?>
<main class="px-3">
    <table class="table table-striped table-bordered">
        <thead class="text-center">
            <tr>
                <th class="text-center small-td">No</th>
                <th class="text-center">Jenis Aset</th>
                <th class="text-center">Nama Aset</th>
                <th class="text-center">Tanggal Hilang</th>
            </tr>
        </thead>
        <?php
        $q = "
            SELECT
                ja.nama AS jenis_aset, 
                a.nama, 
                ah.tanggal  
            FROM 
                aset_hilang AS ah  
            INNER JOIN 
                aset AS a
            ON 
                a.id=ah.id_aset 
            INNER JOIN 
                jenis_aset AS ja  
            ON 
                ja.id=a.id_jenis_aset 
            ";

        if (!empty($_POST['dari_tanggal'] ?? '') && !empty($_POST['sampai_tanggal'] ?? ''))
            $q .= " WHERE ah.tanggal >= '" . $_POST['dari_tanggal'] . "' AND ah.tanggal <= '" . $_POST['sampai_tanggal'] . "'";

        $q .= " ORDER BY ah.id DESC";
        $result = $mysqli->query($q);
        $no = 1;
        ?>
        <tbody>
            <?php if ($result->num_rows) : ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td style="vertical-align: middle;" class="text-center small-td"><?= $no++; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['jenis_aset']; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['nama']; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= tanggalIndonesia($row['tanggal']); ?></td>
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