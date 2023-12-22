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
            <?php Flasher::flash() ?>
            <!-- card -->
            <div class="card mb-3">
                <div class="card-header">
                    <b>Table Indikator Nilai</b>
                </div>
                <div class="card-body">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <?php if (!empty($data['indikator'])) { ?>
                                    <th class="bg-light"><b>Indikator Nilai</b></th>
                                    <?php foreach ($data['indikator'] as $ind) : ?>
                                        <th><?= $ind['rentang_awal'] ?> - <?= $ind['rentang_akhir'] ?> = <?= $ind['bobot_huruf'] ?></th>
                                    <?php endforeach ?>
                                <?php } else { ?>
                                    <th class="table-light">Belum Ada Nilai Indikator</th>
                                <?php } ?>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="card mb-3">
                <!-- card body -->
                <?php if ($data['auth']['cp_count'] > 0) : ?>
                    <div class="card-header">
                        <a href="<?= BASE_URL ?>Penilaian_CPL/geneteratePdfAll" class="btn btn-danger btn-sm"><i class="bi bi-file-pdf"></i> Download PDF</a>
                    </div>
                <?php endif ?>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Action</th>
                                    <th>Nama Mahasiswa</th>
                                    <?php for ($i = 1; $i <= $data['auth']['cp_count']; $i++) : ?>
                                        <th class="text-center">CP<?= $i ?></th>
                                    <?php endfor ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($data['mhs'])) {
                                    foreach ($data['mhs'] as $mhs) {
                                        $total_cp = array_fill(1, $data['auth']['cp_count'], 0); ?>
                                        <tr>
                                            <td class="text-center">
                                                <?php if ($data['auth']['cp_count'] != 0) : ?>
                                                    <a href="javascript:void(0)" onclick="saveNilaiCpMhs('<?= $mhs['id_mhs'] ?>')" class="btn btn-outline-info btn-sm">Luluskan</a>
                                                <?php else : ?>
                                                    <a href="javascript:void(0)" class="btn btn-outline-info btn-sm disabled">Luluskan</a>
                                                <?php endif ?>
                                            </td>
                                            <td>
                                                <a href="<?= BASE_URL ?>Penilaian_CPL/show/<?= $mhs['id_mhs'] ?>"><?= $mhs['name'] ?></a>
                                            </td>
                                            <?php
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
                                            foreach ($column_totals as $total) {
                                                echo '<td class="text-center">' . number_format($total, 2) . '%</td>';
                                            }
                                            ?>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td class="text-center" colspan="<?= $i + 2 ?>">Tidak Ada Data Mahasiswa</td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#table").DataTable();
    })

    function saveNilaiCpMhs(id_mhs) {
        Swal.fire({
            title: "Pemberitahuan !",
            text: "Jika Anda Meluluskan Mahasiswa Ini Maka Nilai Capaian Tiap CPL Akan Tersimpan, Dan Status Mahasiswa Akan Di Luluskan.",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Luluskan"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= BASE_URL ?>Penilaian_CPL/saveNialiCpMhs/' + id_mhs
            }
        });
    }
</script>