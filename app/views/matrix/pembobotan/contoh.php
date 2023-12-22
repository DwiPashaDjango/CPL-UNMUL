<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table border="1" style="width: 100%;">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode MK</th>
                <th>Nama Mk</th>
                <th>SKS</th>
                <?php for ($col = 1; $col <= 1; $col++) : ?>
                    <th>CP <?= $col ?></th>
                <?php endfor ?>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($data['matkul'] as $mk) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $mk['kd_mk'] ?></td>
                    <td><?= $mk['nm_mk'] ?></td>
                    <td><?= $mk['sks'] ?></td>
                    <?php for ($col = 1; $col <= 1; $col++) : ?>
                        <?php
                        if ($mk['cp_' . $col] != null) {
                            $perkalian = ($mk['sks'] * $mk['cp_' . $col]);
                            echo '<td>' . $perkalian . '</td>';
                        } else {
                            echo '<td>0</td>';
                        }
                        ?>
                    <?php endfor ?>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" align="center">Total</th>
                <?php for ($col = 1; $col <= 1; $col++) : ?>
                    <th><?= $data['total_bobot_percp']['cp_' . $col] ?></th>
                <?php endfor ?>
            </tr>
        </tfoot>
    </table>

    <br>
    <br>
    <br>

    <table border="1" style="width: 100%; border: 1px solid;">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode MK</th>
                <th>Nama Mk</th>
                <th>SKS</th>
                <?php for ($col = 1; $col <= $data['auth']['cp_count']; $col++) : ?>
                    <th>CP <?= $col ?></th>
                <?php endfor ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($data['matkul'] as $mk) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $mk['kd_mk'] ?></td>
                    <td><?= $mk['nm_mk'] ?></td>
                    <td><?= $mk['sks'] ?></td>
                    <?php for ($col = 1; $col <= $data['auth']['cp_count']; $col++) : ?>
                        <?php
                        $perkalian = $mk['sks'] * $mk['cp_' . $col];
                        echo '<td>' . number_format($perkalian / $data['total_bobot_percp']['cp_' . $col] * 100, 2) . '</td>';
                        ?>
                    <?php endfor ?>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>