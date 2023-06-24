<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Data Pengajuan Peminjaman Aset</h6>
                    </div>
                </div>

                <div class="card-body pb-3">
                    <div class="table-responsive p-0">
                        <table id="datatable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7 small-td">No</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Tanggal Pengajuan</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Nama Peminjam</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Nama Aset</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Jumlah</th>
                                    <th class="text-uppercase text-center text-secondary text-xs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                                SELECT
                                    pa.id,
                                    DATE(pa.tanggal_waktu_pengajuan) tanggal_pengajuan,
                                    p.nama nama_pegawai,
                                    a.nama nama_aset,
                                    pa.jumlah,
                                    pa.status 
                                FROM 
                                    peminjaman_aset pa 
                                INNER JOIN 
                                    aset a 
                                ON 
                                    pa.id_aset=a.id 
                                INNER JOIN 
                                    pengguna 
                                ON 
                                    pengguna.id=pa.id_user_peminjam 
                                INNER JOIN 
                                    pegawai p  
                                ON 
                                    p.id_pengguna=pengguna.id 
                                ORDER BY 
                                    FIELD(pa.status,1,3,2)
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
                                            <p class="text-secondary mb-0"><?= tanggalIndonesiaString($row['tanggal_pengajuan']); ?></p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-secondary mb-0"><?= $row['nama_pegawai']; ?></p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-secondary mb-0"><?= $row['nama_aset']; ?></p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-secondary mb-0"><?= $row['jumlah']; ?></p>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($row['status'] == 1) : ?>
                                                <span class="badge bg-gradient-info">Menunggu Persetujuan</span>
                                            <?php elseif ($row['status'] == 2) : ?>
                                                <span class="badge bg-gradient-danger">Pengajuan Ditolak</span>
                                            <?php elseif ($row['status'] == 3) : ?>
                                                <span class="badge bg-gradient-success">Pengajuan Diterima</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="small-td">
                                            <a href="?h=detail_pengajuan_peminjaman_aset&id=<?= $row['id'] ?>" class="btn btn-sm btn-info text-white m-0">Lihat</a>
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