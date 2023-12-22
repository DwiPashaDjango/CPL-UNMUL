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
                <th style="text-align: center;">No</th>
                <th>Item</th>
                <?php for ($i = 1; $i <= $data['cp_mhs']['total_cp']; $i++) : ?>
                    <th style="text-align: center;">CP<?= $i ?></th>
                <?php endfor ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center">1</td>
                <td>Nilai Capain Tiap CPL</td>
                <?php
                for ($i = 1; $i <= $data['cp_mhs']['total_cp']; $i++) {
                    echo '<td style="text-align: center;">
                                                ' . $data['cp_mhs']['cp_' . $i] . '%
                                              </td>';
                }
                ?>
            </tr>
            <tr>
                <td style="text-align: center">2</td>
                <td>Total Target</td>
                <?php for ($i = 1; $i <= $data['cp_mhs']['total_cp']; $i++) : ?>
                    <td style="text-align: center;">100.0%</td>
                <?php endfor ?>
            </tr>
            <tr>
                <td style="text-align: center">3</td>
                <td>% Pencapaian CPL</td>
                <?php
                for ($i = 1; $i <= $data['cp_mhs']['total_cp']; $i++) {
                    echo '<td style="text-align: center;">
                                                ' . $data['cp_mhs']['cp_' . $i] . '%
                                              </td>';
                }
                ?>
            </tr>
            <tr>
                <td style="text-align: center">4</td>
                <td>Rata Rata Pencapaian CPL</td>
                <?php
                for ($i = 1; $i <= $data['cp_mhs']['total_cp']; $i++) {
                    $nilai = 'cp_' . $i;
                    if (isset($data['cp_mhs'][$nilai])) {
                        $ave += $data['cp_mhs'][$nilai] / $data['cp_mhs']['total_cp'];
                    }
                }
                echo '<td style="text-align: center;">' . number_format($ave, 2) . '%</td>';
                ?>
                <td colspan="<?= $i ?>" class="table-light"></td>
            </tr>
            <tr>
                <td style="text-align: center">5</td>
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
                echo '<td style="text-align: center;">' . $min . '%</td>';
                echo '<td style="text-align: center;">CP-' . $min_index . '</td>';
                ?>
                <td colspan="<?= $i ?>" class="table-light"></td>
            </tr>
            <tr>
                <td style="text-align: center">6</td>
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
                echo '<td style="text-align: center;">' . $max_cp . '%</td>';
                echo '<td style="text-align: center;">CP-' . $cp_index . '</td>';
                ?>
                <td colspan="<?= $i ?>" class="table-light"></td>
            </tr>
        </tbody>
    </table>
</body>

</html>