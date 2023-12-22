<style>
    tr:nth-child(1),
    tr:nth-child(1) {
        position: sticky;
        top: 0;
    }

    th:nth-child(2),
    td:nth-child(2) {
        position: sticky;
        left: 0;
        z-index: 1;
    }

    td:nth-child(2) {
        background-color: #fff;
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
                    <!-- <div>
                        <a href="#" class="btn btn-white">Create New Project</a>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 mt-6">
            <!-- card -->
            <div class="card mb-6">
                <div class="card-header">
                    <a href="<?= BASE_URL ?>Pembobotan/exportPdf" class="btn btn-danger btn-sm"><i class="bi bi-file-pdf"></i> Download PDF</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Mata Kuliah</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th class="text-center">SKS</th>
                                    <?php for ($i = 1; $i <= $data['auth']['cp_count']; $i++) : ?>
                                        <th class="text-center">CP<?= $i ?></th>
                                    <?php endfor; ?>
                                </tr>
                            </thead>
                            <?php
                            if (!empty($data['matkul'])) {
                                $total_cp = array_fill(1, $data['auth']['cp_count'], 0);
                                foreach ($data['matkul'] as $mk) {
                                    for ($row = 1; $row <= $data['auth']['cp_count']; $row++) {
                                        if ($mk['cp_' . $row] != null) {
                                            $persen = ($mk['sks'] * $mk['cp_' . $row]);
                                            $total_cp[$row] += $persen;
                                        }
                                    }
                                }
                            ?>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($data['matkul'] as $mk) : ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $mk['kd_mk'] ?></td>
                                            <td><?= $mk['nm_mk'] ?></td>
                                            <td class="text-center"><?= $mk['sks'] ?></td>
                                            <?php for ($row = 1; $row <= $data['auth']['cp_count']; $row++) : ?>
                                                <?php
                                                if ($mk['cp_' . $row] != null) {
                                                    $persen = ($mk['sks'] * $mk['cp_' . $row]);
                                                    echo '<td class="text-center">' . number_format(($persen / $data['total_bobot_percp']['cp_' . $row]) * 100, 2) . '%</td>';
                                                } else {
                                                    echo '<td class="text-center">0.00%</td>';
                                                }
                                                ?>
                                            <?php endfor; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-light">
                                        <th class="text-center" colspan="4">Total</th>
                                        <?php for ($i = 1; $i <= $data['auth']['cp_count']; $i++) : ?>
                                            <th class="text-center"><?= number_format($total_cp[$i] / $data['total_bobot_percp']['cp_' . $i] * 100, 2) ?>%</th>
                                        <?php endfor; ?>
                                    </tr>
                                </tfoot>
                            <?php
                            } else {
                            ?>
                                <tfoot>
                                    <tr>
                                        <th class="text-center" colspan="<?= $data['auth']['cp_count'] + 4 ?>">Tidak Ada Data Mata Kuliah</th>
                                    </tr>
                                </tfoot>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>