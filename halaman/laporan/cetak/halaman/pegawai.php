<h4 class="text-center my-3">Laporan Pegawai</h4>
<section class="mb-3 px-3">
    <strong>
        <span style="width: 150px; display: block;">Filter</span>
    </strong>
    <?php if (!empty($_POST['dari_tanggal'] ?? '') && !empty($_POST['sampai_tanggal'] ?? '')) : ?>
        <span>TMT (Terhitung Mulai Tanggal)</span>
        <br>
        <span style="width: 150px; display: inline-block;">Dari Tanggal</span>
        <span>: <?= tanggalIndonesia($_POST['dari_tanggal']); ?></span>
        <br>
        <span style="width: 150px; display: inline-block;">Sampai Tanggal</span>
        <span>: <?= tanggalIndonesia($_POST['sampai_tanggal']); ?></span>
    <?php endif; ?>
    <br>
    <span style="width: 150px; display: inline-block;">Status Pengguna</span>
    <?php if (isset($_POST['status_pengguna'])) : ?>
        <?php if ($_POST['status_pengguna'] == '') : ?>
            <span>: Semua Status Pengguna</span>
        <?php elseif ($_POST['status_pengguna'] == 1) : ?>
            <span>: Admin</span>
        <?php elseif ($_POST['status_pengguna'] == 2) : ?>
            <span>: Petugas</span>
        <?php elseif ($_POST['status_pengguna'] == 3) : ?>
            <span>: Pegawai</span>
        <?php elseif ($_POST['status_pengguna'] == 4) : ?>
            <span>: Kepala Balai</span>
        <?php endif; ?>
        <br>
    <?php endif; ?>
</section>
<main class="px-3">
    <table class="table table-striped table-bordered">
        <thead class="text-center">
            <tr>
                <th class="text-center small-td">No</th>
                <th class="text-center">TMT</th>
                <th class="text-center">NIP</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Jabatan</th>
                <th class="text-center">Status Pengguna</th>
            </tr>
        </thead>
        <?php
        $q = "
        SELECT
            pegawai.*,
            pengguna.status status_pengguna
        FROM 
            pegawai 
        INNER JOIN 
            pengguna 
        ON 
            pengguna.id=pegawai.id_pengguna 
        WHERE 
            1=1";

        if (!empty($_POST['dari_tanggal'] ?? '') && !empty($_POST['sampai_tanggal'] ?? ''))
            $q .= " AND (
                pegawai.tmt >= '" . $_POST['dari_tanggal'] . "' 
                AND 
                pegawai.tmt <= '" . $_POST['sampai_tanggal'] . "' 
            )";

        if (!empty($_POST['status_pengguna'] ?? ''))
            $q .= " AND pengguna.status = " . $_POST['status_pengguna'];

        $q .= " ORDER BY pegawai.nama";

        $result = $mysqli->query($q);
        $no = 1;
        ?>
        <tbody>
            <?php if ($result->num_rows) : ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td style="vertical-align: middle;" class="text-center small-td"><?= $no++; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= tanggalIndonesia($row['tmt']); ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['nip']; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['nama']; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['jabatan']; ?></td>
                        <td style="vertical-align: middle;" class="text-center">
                            <?php if ($row['status_pengguna'] == 1) : ?>
                                Admin
                            <?php elseif ($row['status_pengguna'] == 2) : ?>
                                Petugas
                            <?php elseif ($row['status_pengguna'] == 3) : ?>
                                Pegawai
                            <?php elseif ($row['status_pengguna'] == 4) : ?>
                                Kepala Balai
                            <?php endif; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="text-center">Data Kosong</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>