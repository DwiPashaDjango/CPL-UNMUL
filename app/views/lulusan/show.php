<style>
    .card {
        box-shadow: none;
    }
</style>
<!-- Container fluid -->
<div class="bg-primary pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mb-2 mb-lg-0">
                        <h3 class="mb-0  text-white"><?= $data['title'] ?></h3>
                    </div>
                    <div>
                        <!-- <?= BASE_URL ?>Lulusan/generatePdf/<?= $data['mhs']['id_mhs'] ?> -->
                        <a href="javascript:void(0)" id="export" class="btn btn-danger">Unduh PDF</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row content">
            <div class="col-xl-4 col-lg-4 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr class="table-light">
                                    <th colspan="2" class="text-center">Data Mahasiswa</th>
                                </tr>
                                <tr>
                                    <th class="table-light">Nama Lengkap</th>
                                    <th><?= $data['mhs']['name'] ?></th>
                                </tr>
                                <tr>
                                    <th class="table-light">No Induk Mahasiswa</th>
                                    <th><?= $data['mhs']['nrp'] ?></th>
                                </tr>
                                <tr>
                                    <th class="table-light">Jurusan</th>
                                    <th><?= $data['mhs']['name_jurusan'] ?></th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 mt-6">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered text-center table-light mb-3">
                            <tr>
                                <th><?= $data['mhs']['name'] ?></th>
                                <th><?= $data['mhs']['nrp'] ?></th>
                                <th>AVE CP</th>
                                <?php
                                $thAve = 0;
                                for ($i = 1; $i <= $data['cp_mhs']['total_cp']; $i++) {
                                    $nAve = 'cp_' . $i;
                                    if (isset($data['cp_mhs'][$nAve])) {
                                        $thAve += $data['cp_mhs'][$nAve] / $data['cp_mhs']['total_cp'];
                                    }
                                }
                                echo '<th>' . number_format($thAve, 2) . '%</th>';
                                ?>
                            </tr>
                        </table>

                        <canvas id="myHorizontalBarChart" width="400" height="135"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-16 col-lg-16 col-md-12 col-12 mt-6 mb-6">
                <!-- card -->
                <div class="card">
                    <!-- card body -->
                    <div class="card-header">
                        <b>Rekap Penilaian</b>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Item</th>
                                        <?php for ($i = 1; $i <= $data['cp_mhs']['total_cp']; $i++) : ?>
                                            <th class="text-center">CP<?= $i ?></th>
                                        <?php endfor ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td>Nilai Capain Tiap CPL</td>
                                        <?php
                                        for ($i = 1; $i <= $data['cp_mhs']['total_cp']; $i++) {
                                            echo '<td class="text-center">
                                                        ' . $data['cp_mhs']['cp_' . $i] . '%
                                                      </td>';
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td>Total Target</td>
                                        <?php for ($i = 1; $i <= $data['cp_mhs']['total_cp']; $i++) : ?>
                                            <td class="text-center">100.0%</td>
                                        <?php endfor ?>
                                    </tr>
                                    <tr>
                                        <td class="text-center">4</td>
                                        <td>% Pencapaian CPL</td>
                                        <?php
                                        for ($i = 1; $i <= $data['cp_mhs']['total_cp']; $i++) {
                                            echo '<td class="text-center">
                                                        ' . $data['cp_mhs']['cp_' . $i] . '%
                                                      </td>';
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td class="text-center">5</td>
                                        <td>Minimal Target</td>
                                        <td class="text-center"><?= number_format($data['cp_mhs']['batas'], 2) ?>%</td>
                                        <td class="text-center">
                                            <?php
                                            foreach ($data['indikator'] as $ind) {
                                                if ($data['cp_mhs']['batas'] >= $ind['rentang_awal'] && $data['cp_mhs']['batas'] <= $ind['rentang_akhir']) {
                                                    echo $ind['bobot_huruf'];
                                                    break;
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td colspan="<?= $i ?>" class="table-light"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">6</td>
                                        <td>Rata Rata Pencapaian CPL</td>
                                        <?php
                                        for ($i = 1; $i <= $data['cp_mhs']['total_cp']; $i++) {
                                            $nilai = 'cp_' . $i;
                                            if (isset($data['cp_mhs'][$nilai])) {
                                                $ave += $data['cp_mhs'][$nilai] / $data['cp_mhs']['total_cp'];
                                            }
                                        }
                                        echo '<td class="text-center">' . number_format($ave, 2) . '%</td>';
                                        ?>
                                        <td colspan="<?= $i ?>" class="table-light"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">7</td>
                                        <td>MIN Pencapaian CPL</td>
                                        <?php
                                        $min = PHP_INT_MAX;
                                        $min_index = null;
                                        for ($i = 1; $i <= $data['cp_mhs']['total_cp']; $i++) {
                                            $nMin = 'cp_' . $i;
                                            if (isset($data['cp_mhs'][$nMin])) {
                                                if ($data['cp_mhs'][$nMin] < $min) {
                                                    $min = $data['cp_mhs'][$nMin];
                                                    $min_index = $i;
                                                }
                                            }
                                        }
                                        echo '<td class="text-center">' . $min . '%</td>';
                                        echo '<td class="text-center">CP-' . $min_index . '</td>';
                                        ?>
                                        <td colspan="<?= $i ?>" class="table-light"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">6</td>
                                        <td>MAX Pencapaian CPL</td>
                                        <?php
                                        $max_cp = PHP_INT_MIN;
                                        $cp_index = null;

                                        for ($i = 1; $i <= $data['cp_mhs']['total_cp']; $i++) {
                                            $nMax = 'cp_' . $i;
                                            if (isset($data['cp_mhs'][$nMax])) {
                                                if ($data['cp_mhs'][$nMax] > $max_cp) {
                                                    $max_cp = $data['cp_mhs'][$nMax];
                                                    $cp_index = $i;
                                                }
                                            }
                                        }
                                        echo '<td class="text-center">' . $max_cp . '%</td>';
                                        echo '<td class="text-center">CP-' . $cp_index . '</td>';
                                        ?>
                                        <td colspan="<?= $i ?>" class="table-light"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$dataLabels = [];
$dataValues = [];

$column_totals = array_fill(0, $data['cp_mhs']['total_cp'], 0);

for ($i = 1; $i <= $data['cp_mhs']['total_cp']; $i++) {
    $column_totals[$i - 1] += $data['cp_mhs']['cp_' . $i];
}

foreach ($column_totals as $index => $total) {
    $dataLabels[] = 'CP ' . ($index + 1);
    $dataValues[] = number_format($total, 2);
}

?>

<script src="<?= BASE_URL ?>libs/jquery/dist/jquery.min.js"></script>
<script src="<?= BASE_URL ?>libs/chart-js/chart.js"></script>
<script src="<?= BASE_URL ?>libs/chart-js/chartjs-plugin-annotation.min.js"></script>
<script src="<?= BASE_URL ?>libs/chart-js/chartjs-plugin-datalabels.min.js"></script>
<script src="<?= BASE_URL ?>libs/jspdf/jspdf.min.js"></script>
<script src="<?= BASE_URL ?>libs/html2canvas/html2canvas.min.js"></script>
<script>
    var ctx = document.getElementById('myHorizontalBarChart').getContext('2d');
    var myHorizontalBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($dataLabels); ?>,
            datasets: [{
                label: 'Nilai Capaian CPL <?= json_encode($data['mhs']['name']) ?>',
                data: <?= json_encode($dataValues); ?>,
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(250, 100, 0)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true,
                    max: 100
                }
            },
            plugins: {
                annotation: {
                    drawTime: 'beforeDatasetsDraw',
                    annotations: [{
                        type: 'line',
                        mode: 'horizontal',
                        scaleID: 'x',
                        value: <?= $data['cp_mhs']['batas']; ?>,
                        borderColor: '#FA0404',
                        borderWidth: 10,
                        label: {
                            content: 'Batas Nilai Akhir',
                            enabled: true,
                            position: 'center'
                        }
                    }]
                },
                datalabels: {
                    display: function(context) {
                        return context.dataset.data[context.dataIndex] > 0; // Display labels only for positive values
                    },
                    align: 'end',
                    anchor: 'end',
                    offset: 4,
                    borderRadius: 5,
                    color: 'black',
                    font: {
                        weight: 'bold'
                    },
                    formatter: function(value, context) {
                        return value + '%';
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    $(document).ready(function() {
        $("#export").click(function() {
            html2canvas(document.querySelector('.content')).then((canvas) => {
                let baseImage64 = canvas.toDataURL('image/png');

                let pdf = new jsPDF('l', 'mm', 'a4');
                pdf.addImage(baseImage64, 'PNG', 15, 15, 267, 180);
                pdf.save('<?= $data['mhs']['name'] ?>.pdf');
            })
        })
    })
</script>