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
                            <label class="form-label" for="bulan">Bulan</label>
                            <input type="month" class="form-control p-2" name="bulan" id="bulan" value="<?= $_POST['bulan'] ?? Date('Y-m'); ?>">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php if (isset($_POST['bulan'])) : ?>
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize m-0">Laporan Grafik Peminjaman Aset Bulan <strong><?= BULAN_DALAM_INDONESIA[explode('-', $_POST['bulan'] ?? Date('Y-m'))[1] - 1] ?></strong></h6>
                            <form action="halaman/laporan/cetak/index.php?h=grafik_peminjaman_aset" method="POST" target="_blank">
                                <input type="text" hidden name="bulan" value="<?= $_POST['bulan']; ?>">
                                <button type="submit" class="btn btn-dark m-0">Cetak</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body pb-3">
                        <?php
                        $q = "
                        SELECT
                            COUNT(id) AS jumlah,
                            DAY(tanggal_waktu_pengajuan) AS tanggal
                        FROM
                            peminjaman_aset
                        WHERE
                            YEAR(tanggal_waktu_pengajuan) = '" . explode("-", $_POST['bulan'])[0] . "'
                            AND
                            MONTH(tanggal_waktu_pengajuan) = '" . explode("-", $_POST['bulan'])[1] . "' 
                            AND 
                            status=3
                        GROUP BY 
                            tanggal_waktu_pengajuan 
                    ";
                        $result = $mysqli->query($q)->fetch_all(MYSQLI_ASSOC);
                        $no = 1;
                        ?>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($_POST['bulan'])) : ?>
            <script>
                let chart_data = [];
                let chart_label = [];
                const lastDay = new Date(<?= json_encode(explode("-", $_POST['bulan'])[0]); ?>, <?= json_encode(explode("-", $_POST['bulan'])[0]); ?>, 0);
                const database = <?= json_encode($result); ?>;
                for (let i = 0; i < lastDay.getDate(); i++) {
                    chart_label.push(i + 1);
                    let a = true;
                    database.forEach(element => {
                        if (element.tanggal == (i + 1)) {
                            chart_data.push(element.jumlah);
                            a = false;
                        }
                    });
                    if (a) {
                        chart_data.push(0);
                    }
                    continue;
                }

                const data = {
                    labels: chart_label,
                    datasets: [{
                        label: 'Peminjaman ',
                        backgroundColor: '#66BB6A',
                        borderColor: '#66BB6A',
                        // data: chart_data,
                        data: [1, 2, 3]
                    }]
                };

                const config = {
                    type: 'bar',
                    data: data,
                    options: {
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                title: {
                                    display: true,
                                    text: 'Tanggal Bulan <?= BULAN_DALAM_INDONESIA[explode('-', $_POST['bulan'] ?? Date('Y-m'))[1] - 1] ?>'
                                },
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Jumlah Peminjaman'
                                },
                                grid: {
                                    display: false
                                },
                                beginAtZero: true
                            },
                        },
                        plugins: {
                            legend: true,
                            title: {
                                display: true,
                                text: 'Grafik Peminjaman Aset Bulan <?= BULAN_DALAM_INDONESIA[explode('-', $_POST['bulan'] ?? Date('Y-m'))[1] - 1] ?>'
                            }
                        }
                    },
                };

                const myChart = new Chart(
                    document.getElementById('myChart'),
                    config
                );
            </script>
        <?php endif; ?>
    </div>
</div>