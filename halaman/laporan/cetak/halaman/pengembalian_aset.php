<h4 class="text-center my-3">Laporan Pengembalian Aset</h4>
<section class="mb-3 px-3">
    <strong>
        <span style="width: 250px; display: inline-block;">Filter Tanggal</span>
        <span>: Tanggal Pengembalian Aset</span>
    </strong>
    <br>
    <span style="width: 250px; display: inline-block;">Dari Tanggal</span>
    <span>: <?= tanggalIndonesia($_POST['dari_tanggal']); ?></span>
    <br>
    <span style="width: 250px; display: inline-block;">Sampai Tanggal</span>
    <span>: <?= tanggalIndonesia($_POST['sampai_tanggal']); ?></span>
    <br>
    <span style="width: 250px; display: inline-block;">Petugas Yang Memverifikasi</span>
    <?php if (!empty($_POST['id_pengguna'])) : ?>
        <?php
        $result = $mysqli->query("SELECT * FROM pegawai WHERE id_pengguna=" . $_POST['id_pengguna']);
        $data = $result->fetch_assoc();
        ?>
        <span>: <?= $data['nama']; ?></span>
    <?php else : ?>
        <span>: Semua Petugas</span>
    <?php endif; ?>
</section>
<main class="px-3">
    <table class="table table-striped table-bordered">
        <thead class="text-center">
            <tr>
                <th class="text-center small-td">No</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">NIP</th>
                <th class="text-center">Nama Pegawai</th>
                <th class="text-center">Nama Aset</th>
                <th class="text-center">Jumlah</th>
            </tr>
        </thead>
        <?php
        $q = "
        SELECT
            pegawai.nip nip_pegawai,
            pegawai.nama nama_pegawai,
            a.nama nama_aset, 
            DATE(pa1.tanggal_waktu_pengajuan) tanggal,
            pa.jumlah 
        FROM 
            pengembalian_aset pa1 
        INNER JOIN 
            peminjaman_aset pa   
        ON 
            pa.id=pa1.id_peminjaman_aset 
        INNER JOIN 
            aset a
        ON 
            a.id=pa.id_aset 
        INNER JOIN 
            pengguna 
        ON 
            pengguna.id=pa.id_user_peminjam 
        LEFT JOIN 
            pegawai 
        ON 
            pegawai.id_pengguna=pengguna.id 
        WHERE 
            (
                DATE(pa1.tanggal_waktu_pengajuan) >= '" . $_POST['dari_tanggal'] . "' 
                AND 
                DATE(pa1.tanggal_waktu_pengajuan) <= '" . $_POST['sampai_tanggal'] . "' 
            ) ";

        if (!empty($_POST['id_pengguna'] ?? ''))
            $q .= " AND pa1.id_user_verifikator = " . $_POST['id_pengguna'];

        $q .= " ORDER BY pa1.tanggal_waktu_pengajuan DESC";

        $result = $mysqli->query($q);
        $no = 1;
        ?>
        <tbody>
            <?php if ($result->num_rows) : ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td style="vertical-align: middle;" class="text-center small-td"><?= $no++; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= tanggalIndonesia($row['tanggal']); ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['nip_pegawai']; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['nama_pegawai']; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['nama_aset']; ?></td>
                        <td style="vertical-align: middle;" class="text-center"><?= $row['jumlah']; ?></td>
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