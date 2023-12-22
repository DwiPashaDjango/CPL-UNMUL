<!-- Container fluid -->
<style>
    th:first-child,
    td:first-child {
        position: sticky;
        left: 0;
    }

    .edit-button {
        display: none;
    }

    .table-row:hover .edit-button {
        display: inline;
    }
</style>
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
                        <?php if (!empty($data['matkul'])) : ?>
                            <a href="javascript:void(0)" id="addMk" class="btn btn-white">Tambah Jumlah Mata Kuliah</a>
                            <a href="javascript:void(0)" id="create" class="btn btn-white">Import Nilai</a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 mt-6">
            <?php Flasher::flash() ?>
            <?php Flasher::validationFlash() ?>

            <!-- pilih mata kuliah -->
            <?php if (empty($data['matkul'])) : ?>
                <div class="card">
                    <div class="card-header">
                        <b>Pilih Mata Kuliah Yang Di Ambil Mahasiswa</b>
                    </div>
                    <div class="card-body">
                        <form action="<?= BASE_URL ?>Nilai/SaveMk" method="post">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Kode Mata Kulia</th>
                                            <th>Nama Mata Kuliah</th>
                                            <th class="text-center">Jumlah SKS</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($data['all_mk'] as $amk) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td class="text-center"><?= $amk['kd_mk'] ?></td>
                                                <td><?= $amk['nm_mk'] ?></td>
                                                <td class="text-center"><?= $amk['sks'] ?></td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="kd_mk[]" id="kd_mk" value="<?= $amk['kd_mk'] ?>">
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                            <input type="hidden" name="mhs_id" id="mhs_id" value="<?= $data['mhs']['id_mhs'] ?>">
                            <button class="btn btn-primary" style="float: right;">Simpan</button>
                        </form>
                    </div>
                </div>
            <?php else : ?>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="ex1-tab-1" data-bs-toggle="tab" href="#ex1-tabs-1" role="tab" aria-controls="ex1-tabs-1" aria-selected="true">Data Nilai</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="ex1-tab-2" data-bs-toggle="tab" href="#ex1-tabs-2" role="tab" aria-controls="ex1-tabs-2" aria-selected="false">Data Nilai Per CP</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content mt-5" id="ex1-content">
                    <!-- data nilai mhs -->
                    <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
                        <!-- nilai -->
                        <div class="card mb-6">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center">Kode Mata Kuliah</th>
                                                <th>Nama Mata Kuliah</th>
                                                <th class="text-center">Nilai Angka</th>
                                                <th class="text-center">Nilai Huruf</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($data['matkul'])) { ?>
                                                <?php foreach ($data['matkul'] as $mk) : ?>
                                                    <?php
                                                    $nilaiDimasukkan = false;
                                                    ?>

                                                    <tr class="table-row">
                                                        <td class="text-center"><?= $mk['kd_mk'] ?></td>
                                                        <td><?= $mk['nm_mk'] ?></td>
                                                        <td class="text-center">
                                                            <?php foreach ($data['nilai'] as $nk) : ?>
                                                                <?php if ($nk['kd_mk'] == $mk['kd_mk']) : ?>
                                                                    <?php
                                                                    $nilaiDimasukkan = true;
                                                                    ?>
                                                                    <?= $nk['bobot'] ?>
                                                                    <br>
                                                                    <a href="javascript:void(0)" onclick="editNilai(<?= $nk['id_nilai'] ?>)" class="edit-button" style="font-size: 12px;">Edit</a>
                                                                    <span class="edit-button">|</span>
                                                                    <a href="javascript:void(0)" onclick="deleteNilai(<?= $nk['id_nilai'] ?>)" class="edit-button" style="font-size: 12px;">Hapus</a>
                                                                <?php endif; ?>
                                                            <?php endforeach ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php foreach ($data['nilai'] as $nk) : ?>
                                                                <?php if ($nk['kd_mk'] == $mk['kd_mk']) : ?>
                                                                    <?php
                                                                    $nilaiDanIndikator = array();
                                                                    foreach ($data['indikator'] as $ind) {
                                                                        if ($nk['bobot'] >= $ind['rentang_awal'] && $nk['bobot'] <= $ind['rentang_akhir']) {
                                                                            echo $ind['bobot_huruf'];
                                                                            break;
                                                                        }
                                                                    }
                                                                    ?>
                                                                <?php endif; ?>
                                                            <?php endforeach ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php if (!$nilaiDimasukkan) : ?>
                                                                <a href="javascript:void(0)" onclick="addNilai('<?= $mk['kd_mk'] ?>')" class="btn btn-outline-primary btn-sm"><i class="bi bi-plus"></i></a>
                                                            <?php else : ?>
                                                                <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm disabled"><i class="bi bi-plus"></i></a>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td class="text-center" colspan="4">Tidak Ada Data Mata Kuliah</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end pilih mata kuliah -->
                    </div>
                    <!-- end data nilai mhs -->

                    <!-- data nilai mhs per cp -->
                    <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Mata Kuliah</th>
                                                <?php for ($i = 1; $i <= $data['auth']['cp_count']; $i++) : ?>
                                                    <th class="text-center">CP<?= $i ?></th>
                                                <?php endfor; ?>
                                            </tr>
                                        </thead>

                                        <?php if (!empty($data['nilai'])) { ?>
                                            <tbody>
                                                <?php
                                                $total_cp = array_fill(1, $data['auth']['cp_count'], 0); // Inisialisasi array untuk total per CP

                                                foreach ($data['matkul'] as $mk) : ?>
                                                    <tr>
                                                        <td><?= $mk['nm_mk'] ?></td>
                                                        <?php for ($i = 1; $i <= $data['auth']['cp_count']; $i++) : ?>
                                                            <?php if ($mk['cp_' . $i] != null) { ?>
                                                                <?php
                                                                $bobot_cp = ($mk['sks'] * $mk['cp_' . $i]);
                                                                ?>
                                                                <?php foreach ($data['nilai'] as $nk) : ?>
                                                                    <?php if ($nk['kd_mk'] == $mk['kd_mk']) : ?>
                                                                        <?php
                                                                        $nilai_mhs = $nk['bobot'];
                                                                        $result = number_format(($bobot_cp / $data['total_bobot_percp']['cp_' . $i] * 100), 2);
                                                                        $nilai_per_cp = $nilai_mhs * $result / 100;
                                                                        $total_cp[$i] += $nilai_per_cp;
                                                                        ?>
                                                                        <td class="text-center"><?= number_format($nilai_per_cp, 2) ?>%</td>
                                                                    <?php endif; ?>
                                                                <?php endforeach ?>
                                                            <?php } else { ?>
                                                                <td class="text-center">0.00%</td>
                                                            <?php } ?>
                                                        <?php endfor ?>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                            <tfoot>
                                                <tr class="table-light">
                                                    <th class="text-center">Total</th>
                                                    <?php for ($i = 1; $i <= $data['auth']['cp_count']; $i++) : ?>
                                                        <th class="text-center"><?= number_format($total_cp[$i], 2) ?>%</th>
                                                    <?php endfor; ?>
                                                </tr>
                                            </tfoot>
                                        <?php } else { ?>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center" colspan="<?= $i ?>">Belum Memasukan Data Nilai Mahasiswa</td>
                                                </tr>
                                            </tbody>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end data nilai mhs per cp -->
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<div class="modal fade" id="nilaiModal" tabindex="-1" aria-labelledby="nilaiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="nilaiModalLabel">Import Data Nilai Mahasiswa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Nilai/store" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" value="<?= $data['mhs']['id_mhs'] ?>" name="mhs_id" id="mhs_id">
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">File <span class="text-danger">*</span></label>
                        <input type="file" name="file" id="file" class="form-control" required accept=".xls, .xlsx">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?= BASE_URL ?>_file/template_nilai_mhs.xlsx" download="" class="btn btn-success">Dwonload Template</a>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahNilai" tabindex="-1" aria-labelledby="tambahNilaiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="tambahNilaiLabel">Tambah Nilai Mata Kuliah</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Nilai/storeOne" method="post">
                <div class="modal-body">
                    <input type="hidden" value="<?= $data['mhs']['id_mhs'] ?>" name="mhs_id" id="mhs_id">
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Mata Kuliah</label>
                        <select name="kd_mk" id="kd_mk" class="form-control">
                            <option value="">- Pilih -</option>
                            <?php foreach ($data['matkul'] as $mk) : ?>
                                <option value="<?= $mk['kd_mk'] ?>"><?= $mk['kd_mk'] ?> - <?= $mk['nm_mk'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Masukan Nilai Angka <span class="text-danger">*</span></label>
                        <input type="number" name="bobot" id="bobot" class="form-control" max="100" step="any">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editNilai" tabindex="-1" aria-labelledby="editNilaiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editNilaiLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Nilai/update" method="post">
                <div class="modal-body">
                    <input type="hidden" value="<?= $data['mhs']['id_mhs'] ?>" name="mhs_id" id="mhs_id">
                    <input type="hidden" name="id_nilai" id="id_nilai">
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Masukan Nilai Angka <span class="text-danger">*</span></label>
                        <input type="number" name="bobot_update" id="bobot_update" class="form-control" max="100" step="any">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addMkModal" tabindex="-1" aria-labelledby="addMkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addMkModalLabel">Jumlah Mata Kuliah Yang Belum Di Ambil Oleh <?= $data['mhs']['name'] ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Nilai/SaveMk" method="post">
                <input type="hidden" name="mhs_id" id="mhs_id" value="<?= $data['mhs']['id_mhs'] ?>">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Kode Mata Kulia</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th class="text-center">Jumlah SKS</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($data['all_mk'] as $amk) :
                                    $mkFound = false;
                                    foreach ($data['matkul'] as $mk) :
                                        if ($amk['kd_mk'] == $mk['kd_mk']) {
                                            $mkFound = true;
                                            break;
                                        }
                                    endforeach;
                                    if (!$mkFound) :
                                ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td class="text-center"><?= $amk['kd_mk'] ?></td>
                                            <td><?= $amk['nm_mk'] ?></td>
                                            <td class="text-center"><?= $amk['sks'] ?></td>
                                            <td class="text-center">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="kd_mk[]" id="kd_mk" value="<?= $amk['kd_mk'] ?>">
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    endif;
                                endforeach;
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#create").click(function() {
            $("#nilaiModal").modal('show');
        })

        $("#addMk").click(function() {
            $("#addMkModal").modal('show');
        });
    })

    function addNilai(kd_mk) {
        fetch('<?= BASE_URL ?>Nilai/getMkByKode/' + kd_mk, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                $("#tambahNilai").modal('show');
                $('#kd_mk').on('mousedown', function(event) {
                    event.preventDefault(); // Mencegah klik pada select
                });
                $("#kd_mk").val(data['kd_mk']);
            })
            .catch(error => {
                console.log(error);
            })
    }

    function editNilai(id_nilai) {
        fetch('<?= BASE_URL ?>Nilai/edit/' + id_nilai, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                $("#editNilai").modal('show');
                $("#editNilaiLabel").html(data['name'] + '-' + data['kd_mk']);

                $("#id_nilai").val(data['id_nilai']);
                $("#bobot_update").val(data['bobot']);
            })
            .catch(error => {
                console.log(error);
            })
    }

    function deleteNilai(id_nilai) {
        Swal.fire({
            title: "Warning !",
            text: "Anda Yakin Ingin Menghapus Data Nilai Mahasiswa Ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= BASE_URL ?>Nilai/destroy/' + id_nilai, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            title: "Berhasil",
                            text: "Berhasil Menghapus Data Nilai Mahasiswa.",
                            icon: "success"
                        });
                        setTimeout(() => {
                            window.location.reload()
                        }, 2000);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        });
    }
</script>