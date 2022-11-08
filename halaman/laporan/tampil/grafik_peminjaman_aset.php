<div class="container-fluid py-4">
    <div class="row">
        <div class="col-3">
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
        <div class="col-9">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-success border-radius-lg p-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize m-0">Laporan Grafik Peminjaman Aset Bulan <strong><?= BULAN_DALAM_INDONESIA[explode('-', $_POST['bulan'] ?? Date('Y-m'))[1] - 1] ?></strong></h6>
                        <a target="_blank" href="?halaman/cetak/aset.php?bulan=<?= $_POST['bulan'] ?? Date('Y-m'); ?>" class="btn btn-dark m-0">Cetak</a>
                    </div>
                </div>
                <div class="card-body pb-3">
                    <?php
                    $q = "
                        SELECT
                            COUNT(id) AS jumlah,
                            DAY(timestamp_pengajuan_ditentukan) AS tanggal
                        FROM
                            peminjaman_aset
                        WHERE
                            YEAR(timestamp_pengajuan_ditentukan) = '" . explode("-", $_POST['bulan'] ?? Date('Y-m'))[0] . "'
                            AND
                            MONTH(timestamp_pengajuan_ditentukan) = '" . explode("-", $_POST['bulan'] ?? Date('Y-m'))[1] . "' 
                            AND 
                            ( status = 3 OR status = 6 ) 
                        GROUP BY 
                            tanggal 
                    ";
                    $result = $mysqli->query($q);
                    $no = 1;
                    ?>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let chart_data = [];
    let chart_label = [];
    var date = new Date();
    var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
    const database = <?= json_encode(["jumlah" => 1, "tanggal" => 2]); ?>;
    for (let i = 0; i < lastDay.getDate(); i++) {
        chart_label.push(i + 1);
        chart_data.push(database.tanggal == (i + 1) ? database.jumlah : 0);
        continue;
    }

    const data = {
        labels: chart_label,
        datasets: [{
            label: 'Tanggal ',
            backgroundColor: '#66BB6A',
            borderColor: '#66BB6A',
            data: chart_data,
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
                    }
                },
                y: {
                    grid: {
                        display: false
                    },
                    beginAtZero: true
                },
            },
            plugins: {
                legend: false
            }
        },
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>