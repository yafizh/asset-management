<h4 class="text-center my-3">Laporan Grafik Peminjaman Aset</h4>
<section class="mb-3 px-3">
    <strong>
        <span style="width: 80px; display: block;">Filter</span>
    </strong>
    <span style="width: 80px; display: inline-block;">Bulan</span>
    <span>: <?= BULAN_DALAM_INDONESIA[intval(explode('-', $_POST['bulan'])[1] - 1)]; ?> <?= explode('-', $_POST['bulan'])[0]; ?></span>
</section>
<main class="px-3">
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
    <canvas id="myChart" height="80" class="mb-3"></canvas>
</main>
<!-- Chart JS -->
<script src="../../../assets/js/plugins/chartjs.min.js"></script>
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