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
                        <!-- <?= BASE_URL ?>Penilaian_CPL/generatePdfCpMhs/<?= $data['mhs']['id_mhs'] ?> -->
                        <a href="javascript:void(0)" id="export" class="btn btn-danger">Unduh PDF</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row content">
            <div class="col-xl-4 col-lg-4 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card ">
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
                                <tr>
                                    <th class="table-light">Strata</th>
                                    <th><?= $data['mhs']['strata'] ?> - <?= $data['mhs']['name_jurusan'] ?></th>
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
                                $column_totals = array_fill(0, $data['auth']['cp_count'], 0);

                                foreach ($data['matkul'] as $mk) {
                                    for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
                                        if ($mk['cp_' . $i] != null) {
                                            $bobot_cp = ($mk['sks'] * $mk['cp_' . $i]);
                                            $persen = ($bobot_cp / $data['total_bobot_percp']['cp_' . $i]) * 100;
                                            foreach ($data['nilai'] as $nk) {
                                                if ($nk['kd_mk'] == $mk['kd_mk']) {
                                                    $nilai_mhs = $nk['bobot'];
                                                    $result = ($persen * $nilai_mhs) / 100;
                                                    $column_totals[$i - 1] += $result;
                                                }
                                            }
                                        }
                                    }
                                }

                                $jmlnilai = count($column_totals);
                                $totalNilai = array_sum($column_totals);
                                echo '<th>' . number_format($totalNilai / $jmlnilai, 2) . '%</th>';
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
                                        <?php for ($i = 1; $i <= $data['auth']['cp_count']; $i++) : ?>
                                            <th class="text-center">CP<?= $i ?></th>
                                        <?php endfor ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td>Nilai Capain Tiap CPL</td>
                                        <?php
                                        $column_totals = array_fill(0, $data['auth']['cp_count'], 0);

                                        foreach ($data['matkul'] as $mk) {
                                            for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
                                                if ($mk['cp_' . $i] != null) {
                                                    $bobot_cp = ($mk['sks'] * $mk['cp_' . $i]);
                                                    $persen = ($bobot_cp / $data['total_bobot_percp']['cp_' . $i]) * 100;

                                                    foreach ($data['nilai'] as $nk) {
                                                        if ($nk['kd_mk'] == $mk['kd_mk']) {
                                                            $nilai_mhs = $nk['bobot'];
                                                            $result = ($persen * $nilai_mhs) / 100;
                                                            $column_totals[$i - 1] += $result;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        foreach ($column_totals as $index => $total) {
                                            echo '<td class="text-center">
                                                                ' . number_format($total, 2) . '%
                                                              </td>';
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td>Total Target</td>
                                        <?php for ($i = 1; $i <= $data['auth']['cp_count']; $i++) : ?>
                                            <td class="text-center">100.0%</td>
                                        <?php endfor ?>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3</td>
                                        <td>% Pencapaian CPL</td>
                                        <?php
                                        $column_totals = array_fill(0, $data['auth']['cp_count'], 0);

                                        foreach ($data['matkul'] as $mk) {
                                            for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
                                                if ($mk['cp_' . $i] != null) {
                                                    $bobot_cp = ($mk['sks'] * $mk['cp_' . $i]);
                                                    $persen = ($bobot_cp / $data['total_bobot_percp']['cp_' . $i]) * 100;

                                                    foreach ($data['nilai'] as $nk) {
                                                        if ($nk['kd_mk'] == $mk['kd_mk']) {
                                                            $nilai_mhs = $nk['bobot'];
                                                            $result = ($persen * $nilai_mhs) / 100;
                                                            $column_totals[$i - 1] += $result;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        foreach ($column_totals as $index => $total) {
                                            echo '<td class="text-center">
                                                                ' . number_format($total, 2) . '%
                                                              </td>';
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td class="text-center">4</td>
                                        <td>Rata Rata Pencapaian CPL</td>
                                        <?php
                                        $column_totals = array_fill(0, $data['auth']['cp_count'], 0);

                                        foreach ($data['matkul'] as $mk) {
                                            for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
                                                if ($mk['cp_' . $i] != null) {
                                                    $bobot_cp = ($mk['sks'] * $mk['cp_' . $i]);
                                                    $persen = ($bobot_cp / $data['total_bobot_percp']['cp_' . $i]) * 100;

                                                    foreach ($data['nilai'] as $nk) {
                                                        if ($nk['kd_mk'] == $mk['kd_mk']) {
                                                            $nilai_mhs = $nk['bobot'];
                                                            $result = ($persen * $nilai_mhs) / 100;
                                                            $column_totals[$i - 1] += $result;
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        $jmlnilai = count($column_totals);
                                        $totalNilai = array_sum($column_totals);
                                        echo '<td class="text-center">' . number_format($totalNilai / $jmlnilai, 2) . '%</td>';
                                        ?>
                                        <td colspan="<?= $i ?>" class="table-light"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">5</td>
                                        <td>Minimal Target</td>
                                        <td class="text-center"><?= number_format($data['auth']['batas'], 2) ?>%</td>
                                        <td class="text-center">
                                            <?php
                                            foreach ($data['indikator'] as $ind) {
                                                if ($data['auth']['batas'] >= $ind['rentang_awal'] && $data['auth']['batas'] <= $ind['rentang_akhir']) {
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
                                        <td>MIN Pencapaian CPL</td>
                                        <?php
                                        $column_totals = array_fill(0, $data['auth']['cp_count'], 0);

                                        foreach ($data['matkul'] as $mk) {
                                            for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
                                                if ($mk['cp_' . $i] != null) {
                                                    $bobot_cp = ($mk['sks'] * $mk['cp_' . $i]);
                                                    $persen = ($bobot_cp / $data['total_bobot_percp']['cp_' . $i]) * 100;

                                                    foreach ($data['nilai'] as $nk) {
                                                        if ($nk['kd_mk'] == $mk['kd_mk']) {
                                                            $nilai_mhs = $nk['bobot'];
                                                            $result = ($persen * $nilai_mhs) / 100;
                                                            $column_totals[$i - 1] += $result;
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        $nonNullValues = array_filter($column_totals, function ($value) {
                                            return $value !== null;
                                        });

                                        $min_cp_value = min($nonNullValues);
                                        $min_cp_index = array_search($min_cp_value, $column_totals) + 1;

                                        echo '<td class="text-center">' . number_format($min_cp_value, 2) . '%</td>';
                                        echo '<td class="text-center">CP ' . $min_cp_index . '</td>';
                                        ?>
                                        <td colspan="<?= $i ?>" class="table-light"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">7</td>
                                        <td>MAX Pencapaian CPL</td>
                                        <?php
                                        $column_totals = array_fill(0, $data['auth']['cp_count'], 0);

                                        foreach ($data['matkul'] as $mk) {
                                            for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
                                                if ($mk['cp_' . $i] != null) {
                                                    $bobot_cp = ($mk['sks'] * $mk['cp_' . $i]);
                                                    $persen = ($bobot_cp / $data['total_bobot_percp']['cp_' . $i]) * 100;

                                                    foreach ($data['nilai'] as $nk) {
                                                        if ($nk['kd_mk'] == $mk['kd_mk']) {
                                                            $nilai_mhs = $nk['bobot'];
                                                            $result = ($persen * $nilai_mhs) / 100;
                                                            $column_totals[$i - 1] += $result;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        $nonNullValues = array_filter($column_totals, function ($value) {
                                            return $value !== null;
                                        });

                                        $max_cp_value = max($nonNullValues);
                                        $max_cp_index = array_search($max_cp_value, $column_totals) + 1;

                                        echo '<td class="text-center">' . number_format($max_cp_value, 2) . '%</td>';
                                        echo '<td class="text-center">CP ' . $max_cp_index . '</td>';
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

<!-- perhitungan untuk chart -->
<?php
$dataLabels = [];
$dataValues = [];

$column_totals = array_fill(0, $data['auth']['cp_count'], 0);

foreach ($data['matkul'] as $mk) {
    for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
        if ($mk['cp_' . $i] != null) {
            $bobot_cp = ($mk['sks'] * $mk['cp_' . $i]);
            $persen = ($bobot_cp / $data['total_bobot_percp']['cp_' . $i]) * 100;

            foreach ($data['nilai'] as $nk) {
                if ($nk['kd_mk'] == $mk['kd_mk']) {
                    $nilai_mhs = $nk['bobot'];
                    $result = ($persen * $nilai_mhs) / 100;
                    $column_totals[$i - 1] += number_format($result, 2);
                }
            }
        }
    }
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
                        value: <?= $data['auth']['batas']; ?>,
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
                        console.log(context.dataset.data[context.dataIndex]);
                        return context.dataset.data[context.dataIndex] > 0;
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