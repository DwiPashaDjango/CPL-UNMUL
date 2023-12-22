<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?></title>
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: gray;
        }
    </style>
</head>

<body>
    <table id="customers">
        <tr>
            <th colspan="2" style="text-align: center; color:#f2f2f2;">Data Mahasiswa</th>
        </tr>
        <tr>
            <th style="color:#f2f2f2;">Nama Lengkap</th>
            <th style="background-color: #f2f2f2;"><?= $data['mhs']['name'] ?></th>
        </tr>
        <tr>
            <th style="color:#f2f2f2;">No Induk Mahasiswa</th>
            <th style="background-color: #f2f2f2;"><?= $data['mhs']['nrp'] ?></th>
        </tr>
        <tr>
            <th style="color:#f2f2f2;">Jurusan</th>
            <th style="background-color: #f2f2f2;"><?= $data['mhs']['name_jurusan'] ?></th>
        </tr>
    </table>
    <br>
    <br>

    <table id="customers">
        <thead>
            <tr>
                <th style="text-align: center">No</th>
                <th>Item</th>
                <?php for ($i = 1; $i <= $data['auth']['cp_count']; $i++) : ?>
                    <th style="text-align: center">CP<?= $i ?></th>
                <?php endfor ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center">1</td>
                <td>Nilai Capain Tiap CPL</td>
                <?php
                $column_totals = array_fill(0, $data['auth']['cp_count'], 0);

                foreach ($data['matkul'] as $mk) {
                    for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
                        if ($mk['cp_' . $i] != null) {
                            $bobot_cp = ($mk['cp_' . $i] / $data['total_cp']['cp_' . $i]) * 100;

                            foreach ($data['nilai'] as $nk) {
                                if ($nk['kd_mk'] == $mk['kd_mk']) {
                                    $nilai_mhs = $nk['bobot'];
                                    $result = ($bobot_cp * $nilai_mhs) / 100;
                                    $column_totals[$i - 1] += number_format($result, 2);
                                }
                            }
                        }
                    }
                }
                foreach ($column_totals as $index => $total) {
                    echo '<td style="text-align: center">
                                                        ' . $total . '%
                                                      </td>';
                }
                ?>
            </tr>
            <tr>
                <td style="text-align: center">2</td>
                <td>Total Target</td>
                <?php for ($i = 1; $i <= $data['auth']['cp_count']; $i++) : ?>
                    <td style="text-align: center">100.0%</td>
                <?php endfor ?>
            </tr>
            <tr>
                <td style="text-align: center">3</td>
                <td>% Pencapaian CPL</td>
                <?php
                $column_totals = array_fill(0, $data['auth']['cp_count'], 0);

                foreach ($data['matkul'] as $mk) {
                    for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
                        if ($mk['cp_' . $i] != null) {
                            $bobot_cp = ($mk['cp_' . $i] / $data['total_cp']['cp_' . $i]) * 100;

                            foreach ($data['nilai'] as $nk) {
                                if ($nk['kd_mk'] == $mk['kd_mk']) {
                                    $nilai_mhs = $nk['bobot'];
                                    $result = ($bobot_cp * $nilai_mhs) / 100;
                                    $column_totals[$i - 1] += number_format($result, 2);
                                }
                            }
                        }
                    }
                }
                foreach ($column_totals as $index => $total) {
                    echo '<td style="text-align: center">
                                                        ' . $total . '%
                                                      </td>';
                }
                ?>
            </tr>
            <tr>
                <td style="text-align: center">4</td>
                <td>Rata Rata Pencapaian CPL</td>
                <?php
                $column_totals = array_fill(0, $data['auth']['cp_count'], 0);

                foreach ($data['matkul'] as $mk) {
                    for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
                        if ($mk['cp_' . $i] != null) {
                            $bobot_cp = ($mk['cp_' . $i] / $data['total_cp']['cp_' . $i]) * 100;

                            foreach ($data['nilai'] as $nk) {
                                if ($nk['kd_mk'] == $mk['kd_mk']) {
                                    $nilai_mhs = $nk['bobot'];
                                    $result = ($bobot_cp * $nilai_mhs) / 100;
                                    $column_totals[$i - 1] += $result;
                                }
                            }
                        }
                    }
                }

                $jmlnilai = count($column_totals);
                $totalNilai = array_sum($column_totals);
                echo '<td style="text-align: center">' . number_format($totalNilai / $jmlnilai, 2) . '%</td>';
                ?>
                <td colspan="<?= $i ?>" class="table-light"></td>
            </tr>
            <tr>
                <td style="text-align: center">5</td>
                <td>MIN Pencapaian CPL</td>
                <?php
                $column_totals = array_fill(0, $data['auth']['cp_count'], 0);

                foreach ($data['matkul'] as $mk) {
                    for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
                        if ($mk['cp_' . $i] != null) {
                            $bobot_cp = ($mk['cp_' . $i] / $data['total_cp']['cp_' . $i]) * 100;

                            foreach ($data['nilai'] as $nk) {
                                if ($nk['kd_mk'] == $mk['kd_mk']) {
                                    $nilai_mhs = $nk['bobot'];
                                    $result = ($bobot_cp * $nilai_mhs) / 100;
                                    $column_totals[$i - 1] += number_format($result, 2);
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

                echo '<td style="text-align: center">' . $min_cp_value . '%</td>';
                echo '<td style="text-align: center">CP ' . $min_cp_index . '</td>';
                ?>
                <td colspan="<?= $i ?>" class="table-light"></td>
            </tr>
            <tr>
                <td style="text-align: center">6</td>
                <td>MAX Pencapaian CPL</td>
                <?php
                $column_totals = array_fill(0, $data['auth']['cp_count'], 0);

                foreach ($data['matkul'] as $mk) {
                    for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
                        if ($mk['cp_' . $i] != null) {
                            $bobot_cp = ($mk['cp_' . $i] / $data['total_cp']['cp_' . $i]) * 100;

                            foreach ($data['nilai'] as $nk) {
                                if ($nk['kd_mk'] == $mk['kd_mk']) {
                                    $nilai_mhs = $nk['bobot'];
                                    $result = ($bobot_cp * $nilai_mhs) / 100;
                                    $column_totals[$i - 1] += number_format($result, 2);
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

                echo '<td style="text-align: center">' . $max_cp_value . '%</td>';
                echo '<td style="text-align: center">CP ' . $max_cp_index . '</td>';
                ?>
                <td colspan="<?= $i ?>" class="table-light"></td>
            </tr>
        </tbody>
    </table>
</body>

</html>