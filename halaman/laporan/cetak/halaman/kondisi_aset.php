<h4 class="text-center my-3">Laporan Kondisi Aset</h4>
<section class="mb-3 px-3">
    <strong>
        <span style="width: 150px; display: inline-block;">Filter Tanggal</span>
        <span>: Tanggal</span>
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
                <th class="text-center small-td" rowspan="2">No</th>
                <th class="text-center" rowspan="2">Nama Aset</th>
                <th class="text-center" colspan="4">Kondisi</th>
            </tr>
            <tr>
                <th class="text-center">Baik</th>
                <th class="text-center">Hilang</th>
                <th class="text-center">Rusak</th>
                <th class="text-center">Dimusnahkan</th>
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
                        <td style="vertical-align: middle;" class="text-center small-td"><?= $no++; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['nama'] ?? 0 ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['hilang'] ?? 0; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['masuk'] ?? 0; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['rusak'] ?? 0; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['dimusnahkan'] ?? 0; ?></td>
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