<style>
    .card {
        box-shadow: none;
    }
</style>
<!-- Container fluid -->
<div class="bg-primary pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <div class="row mb-6">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mb-2 mb-lg-0">
                        <h3 class="mb-0 text-white"><?= $data['title'] ?></h3>
                    </div>
                    <div>
                        <a href="javascript:void(0)" id="export" class="btn btn-white">Unduh PDF</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-xl-12 mt-6">
                    <div class="alert alert-info">
                        <b>
                            <h4>Evaluasi Penilaian CP Lulusan Jurusan <?= $data['auth']['name_jurusan'] ?></h4>
                        </b>
                        <br>
                        <b><span class="text-danger">*</span>
                            Jumlah Mahasiswa yang di Evaluasi : <?= count($data['mhs']) ?></b>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- cp min - max -->
                <div class="col-xl-6 col-lg-4 col-md-12 col-12">
                    <!-- cp min - max -->
                    <div class="card mb-6">
                        <div class="card-header">
                            <b>Evaluasi</b>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <table class="table table-bordered table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th class="table-light">CP MIN</th>
                                                <th class="table-light">Total</th>
                                            </tr>
                                            <?php
                                            $batas = (float)$data['auth']['batas'];
                                            $jumlah_mhs_di_bawah_batas_cp = array_fill(0, $data['auth']['cp_count'], 0);
                                            foreach ($data['mhs'] as $mhs) {
                                                $column_totals = array_fill(0, $data['auth']['cp_count'], 0);
                                                foreach ($data['matkul'] as $mk) {
                                                    for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
                                                        if ($mk['cp_' . $i] != null) {
                                                            $bobot_cp = ($mk['sks'] * $mk['cp_' . $i]);
                                                            $persen = ($bobot_cp / $data['total_bobot_percp']['cp_' . $i]) * 100;

                                                            foreach ($data['nilai'] as $nk) {
                                                                if ($nk['mhs_id'] == $mhs['id_mhs'] && $nk['kd_mk'] == $mk['kd_mk']) {
                                                                    $nilai_mhs = $nk['bobot'];
                                                                    $result = ($persen * $nilai_mhs) / 100;
                                                                    $column_totals[$i - 1] += $result;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                                foreach ($column_totals as $key => $total) {
                                                    if ($total < $batas) {
                                                        $jumlah_mhs_di_bawah_batas_cp[$key]++;
                                                    }
                                                }
                                            }
                                            for ($i = 0; $i < $data['auth']['cp_count']; $i++) {
                                                echo '<tr>
                                                        <th class="table-light">CP ' . $i + 1 . '</th>
                                                        <th> ' . $jumlah_mhs_di_bawah_batas_cp[$i] . ' </th>
                                                     </tr>';
                                            }
                                            ?>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-lg-6">
                                    <table class="table table-bordered table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th class="table-light">CP MAX</th>
                                                <th class="table-light">Total</th>
                                            </tr>
                                            <?php
                                            $batas = (float)$data['auth']['batas'];
                                            $jumlah_mhs_di_bawah_batas_cp = array_fill(0, $data['auth']['cp_count'], 0);
                                            foreach ($data['mhs'] as $mhs) {
                                                $column_totals = array_fill(0, $data['auth']['cp_count'], 0);
                                                foreach ($data['matkul'] as $mk) {
                                                    for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
                                                        if ($mk['cp_' . $i] != null) {
                                                            $bobot_cp = ($mk['sks'] * $mk['cp_' . $i]);
                                                            $persen = ($bobot_cp / $data['total_bobot_percp']['cp_' . $i]) * 100;

                                                            foreach ($data['nilai'] as $nk) {
                                                                if ($nk['mhs_id'] == $mhs['id_mhs'] && $nk['kd_mk'] == $mk['kd_mk']) {
                                                                    $nilai_mhs = $nk['bobot'];
                                                                    $result = ($persen * $nilai_mhs) / 100;
                                                                    $column_totals[$i - 1] += $result;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                                foreach ($column_totals as $key => $total) {
                                                    if ($total > $batas) {
                                                        $jumlah_mhs_di_bawah_batas_cp[$key]++;
                                                    }
                                                }
                                            }
                                            for ($i = 0; $i < $data['auth']['cp_count']; $i++) {
                                                echo '<tr>
                                                        <th class="table-light">CP ' . $i + 1 . '</th>
                                                        <th> ' . $jumlah_mhs_di_bawah_batas_cp[$i] . ' </th>
                                                     </tr>';
                                            }
                                            ?>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- rata rata -->
                <div class="col-xl-6 col-lg-4 col-md-12 col-12">
                    <!-- rata rata -->
                    <div class="card">
                        <div class="card-header">
                            <b>Evalasi Rata Rata Pencapaian CPL</b>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr class="table-light">
                                            <th>CP Count</th>
                                            <th>Rata-Rata</th>
                                        </tr>
                                        <?php
                                        $jml_mhs = count($data['mhs']);
                                        foreach ($data['mhs'] as $mhs) {
                                            $column_totals = array_fill(0, $data['auth']['cp_count'], 0);
                                            foreach ($data['matkul'] as $mk) {
                                                for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
                                                    if ($mk['cp_' . $i] != null) {
                                                        $bobot_cp = ($mk['sks'] * $mk['cp_' . $i]);
                                                        $persen = ($bobot_cp / $data['total_bobot_percp']['cp_' . $i]) * 100;

                                                        foreach ($data['nilai'] as $nk) {
                                                            if ($nk['mhs_id'] == $mhs['id_mhs'] && $nk['kd_mk'] == $mk['kd_mk']) {
                                                                $nilai_mhs = $nk['bobot'];
                                                                $result = ($persen * $nilai_mhs) / 100;
                                                                $total_cp[$i] += $result;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
                                            echo '<tr>
                                                        <th class="table-light">CP ' . $i . '</th>
                                                        <th>' . number_format($total_cp[$i] / $jml_mhs, 2) . '%</th>
                                                     </tr>';
                                        }
                                        ?>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- grafik -->
                <div class="col-xl-6 col-lg-6 col-md-12 col-12 mt-6">
                    <!-- rata rata -->
                    <div class="card">
                        <div class="card-header">
                            <b>Grafik Evaluasi Rata-Rata Penilaian CPL</b>
                        </div>
                        <div class="card-body">
                            <canvas id="myHorizontalBarChart" width="400" height="135"></canvas>
                        </div>
                    </div>
                </div>

                <!-- jml cp terendah -->
                <div class="col-xl-6 col-lg-6 col-md-12 col-12 mt-6">
                    <div class="card">
                        <div class="card-header">
                            <b>CPL Dengan Capaian Terendah</b>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th class="table-light">CP Count</th>
                                        <th class="table-light">Rata-Rata</th>
                                    </tr>
                                    <tr>
                                        <?php
                                        $batas = (float)$data['auth']['batas'];
                                        $jumlah_mhs_di_bawah_batas_cp = array_fill(0, $data['auth']['cp_count'], 0);
                                        foreach ($data['mhs'] as $mhs) {
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
                                        }

                                        $nonNullValues = array_filter($column_totals, function ($value) {
                                            return $value !== null;
                                        });

                                        $min_cp_value = min($nonNullValues);
                                        $min_cp_index = array_search($min_cp_value, $column_totals) + 1;

                                        echo '<th class="table-light">CP ' . $min_cp_index . '</th>';
                                        echo '<th class="text-center">' . number_format($min_cp_value / $jml_mhs, 2) . '%</th>';
                                        ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="table-light">
                                            Rata-Rata Nilai Mahasiswa Adalah : <b><?= number_format($min_cp_value / $jml_mhs, 2) ?>%</b>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>libs/jquery/dist/jquery.min.js"></script>
<script src="<?= BASE_URL ?>libs/chart-js/chart.js"></script>
<script src="<?= BASE_URL ?>libs/chart-js/chartjs-plugin-annotation.min.js"></script>
<script src="<?= BASE_URL ?>libs/chart-js/chartjs-plugin-datalabels.min.js"></script>
<script src="<?= BASE_URL ?>libs/jspdf/jspdf.min.js"></script>
<script src="<?= BASE_URL ?>libs/html2canvas/html2canvas.min.js"></script>

<?php
foreach ($data['mhs'] as $mhs) {
    $column_totals = array_fill(0, $data['auth']['cp_count'], 0);
    foreach ($data['matkul'] as $mk) {
        for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
            if ($mk['cp_' . $i] != null) {
                $bobot_cp = ($mk['sks'] * $mk['cp_' . $i]);
                $persen = ($bobot_cp / $data['total_bobot_percp']['cp_' . $i]) * 100;

                foreach ($data['nilai'] as $nk) {
                    if ($nk['mhs_id'] == $mhs['id_mhs'] && $nk['kd_mk'] == $mk['kd_mk']) {
                        $nilai_mhs = $nk['bobot'];
                        $result = ($persen * $nilai_mhs) / 100;
                        $total_cp_json[$i] += $result;
                    }
                }
            }
        }
    }
}
for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
    $dataLabels[] = 'CP ' . ($i);
    $dataValues[] = number_format($total_cp_json[$i] / $jml_mhs, 2);
}
?>

<script>
    var ctx = document.getElementById('myHorizontalBarChart').getContext('2d');
    var myHorizontalBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($dataLabels); ?>,
            datasets: [{
                label: 'Grafik Rata-Rata Penilain CPL',
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
                pdf.save('Evaluasi Penilaian CP Lulusan.pdf ');
            })
        })
    })
</script>