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
                    <div>
                        <?php if ($data['auth']['cp_count'] != 0) { ?>
                            <a href="javascript:void(0)" onclick="return editCpCount()" class="btn btn-white">Edit Jumlah CP Dan Batas</a>
                        <?php } ?>
                        <a href="<?= BASE_URL ?>Matkul/exportPdf" class="btn btn-white">Download PDF</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 mt-6">
            <!-- card -->
            <?php Flasher::flash() ?>
            <?php Flasher::validationFlash() ?>
            <div class="card mb-6">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered nowrap" id="table2" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Action</th>
                                    <th class="text-center">Kode Mata Kuliah</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th class="text-center">SKS</th>
                                    <?php for ($i = 1; $i <= $data['auth']['cp_count']; $i++) : ?>
                                        <th class="text-center">CP<?= $i ?></th>
                                    <?php endfor; ?>
                                </tr>
                            </thead>
                            <?php if (!empty($data['mata_kuliah'])) { ?>
                                <tbody>
                                    <?php foreach ($data['mata_kuliah'] as $mk) : ?>
                                        <tr>
                                            <td class="text-center">
                                                <?php $found = false; ?>
                                                <?php foreach ($data['matkul'] as $act) : ?>
                                                    <?php if ($act['kd_mk'] == $mk['kd_mk']) : ?>
                                                        <a href="javascript:void(0)" onclick="deleteCp('<?= $act['id_cp'] ?>')" class="btn btn-danger btn-sm"><i class="bi bi-x"></i></a>
                                                        <a href="javascript:void(0)" onclick="showCp('<?= $act['id_cp'] ?>')" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                                        <?php $found = true;
                                                        break; ?>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                                <?php if (!$found) : ?>
                                                    <a href="javascript:void(0)" onclick="addCp('<?= $mk['kd_mk'] ?>')" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> Masukan CP</a>
                                                <?php endif ?>
                                            </td>
                                            <td class="text-center"><?= $mk['kd_mk'] ?></td>
                                            <td><?= $mk['nm_mk'] ?></td>
                                            <td class="text-center"><?= $mk['sks'] ?></td>
                                            <?php for ($i = 1; $i <= $data['auth']['cp_count']; $i++) : ?>
                                                <?php $cp_found = false; ?>
                                                <?php foreach ($data['matkul'] as $bobot) : ?>
                                                    <?php if ($bobot['kd_mk'] == $mk['kd_mk'] && $bobot['cp_' . $i] !== null) : ?>
                                                        <?php
                                                        $cp_value = $bobot['cp_' . $i];
                                                        $cp_found = true;
                                                        ?>
                                                        <?php if ($cp_value == 1) : ?>
                                                            <td class="text-center bg-success text-white"><?= $cp_value ?></td>
                                                        <?php elseif ($cp_value == 2) : ?>
                                                            <td class="text-center bg-danger text-white"><?= $cp_value ?></td>
                                                        <?php elseif ($cp_value == 3) : ?>
                                                            <td class="text-center bg-warning text-white"><?= $cp_value ?></td>
                                                        <?php else : ?>
                                                            <td class="text-center">-</td>
                                                        <?php endif; ?>
                                                        <?php break; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!$cp_found) : ?>
                                                    <td class="text-center">-</td>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-center">Total</th>
                                        <?php for ($i = 1; $i <= $data['auth']['cp_count']; $i++) : ?>
                                            <th class="text-center"><?= $data['total_cp']['cp_' . $i] ?></th>
                                        <?php endfor; ?>
                                    </tr>
                                </tfoot>
                            <?php } else { ?>
                                <tfoot>
                                    <tr>
                                        <td class="text-center" colspan="<?= $i + 3 ?>">Tidak Ada Data Mata Kuliah</td>
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

<div class="modal fade" id="addMatkulModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addMatkulModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Matkul/createMatkul" method="post">
                <div class="modal-body">
                    <div class="form-group mb-5">
                        <label for="" class="mb-2">Mata Kuliah <span class="text-danger">*</span></label>
                        <select name="kd_mk" id="kd_mk" class="form-control">
                            <option value="">- Pilih -</option>
                            <?php foreach ($data['mata_kuliah'] as $smk) : ?>
                                <option value="<?= $smk['kd_mk'] ?>"><?= $smk['kd_mk'] ?> - <?= $smk['nm_mk'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="row">
                        <?php for ($i = 1; $i <= $data['auth']['cp_count']; $i++) { ?>
                            <div class="col-lg-3">
                                <div class="form-group mb-3">
                                    <label for="" class="mb-2">CP-<?= $i ?></label>
                                    <input type="number" name="cp_<?= $i ?>" id="cp_<?= $i ?>" class="form-control" min="1" max="3">
                                </div>
                            </div>
                        <?php } ?>
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

<div class="modal fade" id="editMatkulModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editMatkulModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Matkul/update" method="post">
                <div class="modal-body">
                    <div class="form-group mb-5">
                        <input type="hidden" name="id_cp" id="id_cp">
                        <input type="hidden" value="<?= $data['auth']['cp_count'] ?>" name="cp_count" />
                        <label for="" class="mb-2">Mata Kuliah <span class="text-danger">*</span></label>
                        <select name="kd_mk_update" id="kd_mk_update" class="form-control" disabled>
                            <option value="">- Pilih -</option>
                            <?php foreach ($data['mata_kuliah'] as $smk) : ?>
                                <option value="<?= $smk['kd_mk'] ?>"><?= $smk['kd_mk'] ?> - <?= $smk['nm_mk'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="row">
                        <?php for ($i = 1; $i <= $data['auth']['cp_count']; $i++) { ?>
                            <div class="col-lg-3">
                                <div class="form-group mb-3">
                                    <label for="" class="mb-2">CP-<?= $i ?></label>
                                    <input type="number" name="cp_<?= $i ?>_update" id="cp_<?= $i ?>_update" class="form-control" max="3">
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="updateCpCount" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateCpCountLabel">Jumlah CP Dan Batas Nilai Minimal Jurusan <?= $data['auth']['name_jurusan'] ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-xmarx"></i></button>
            </div>
            <form action="<?= BASE_URL ?>Matkul/updateCpCount" method="POST">
                <div class="modal-body">
                    <div id="msg">
                    </div>
                    <input type="hidden" name="kd_jrs" id="kd_jrs" value="<?= $data['auth']['kd_jrs'] ?>">
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Minimal Target Pencapaian <span class="text-danger">*</span></label>
                        <input type="number" name="batas_update" id="batas_update" value="<?= $data['auth']['batas'] ?>" class="form-control" min="1" step="any" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Jumlah CP <span class="text-danger">*</span></label>
                        <input type="number" name="cp_count_update" id="cp_count_update" value="<?= $data['auth']['cp_count'] ?>" max="20" class="form-control" min="1" required>
                    </div>
                    <span class="text-danger mt-3">* Batas Maximal Pengisian CP Adalah 20</span>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="<?= BASE_URL ?>libs/jquery/dist/jquery.min.js"></script>

<script>
    function addCp(kd_mk) {
        fetch('<?= BASE_URL ?>Mata_Kuliah/show/' + kd_mk, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                $("#addMatkulModal").modal('show');
                $("#addMatkulModalLabel").html('Tambah Jumlah CP Pada Mata Kuliah ' + data['nm_mk']);
                $("#kd_mk").val(data['kd_mk']);
            })
            .catch(error => {
                console.log(error);
            })
    }

    function showCp(id_cp) {
        console.log(id_cp);
        fetch('<?= BASE_URL ?>Matkul/show/' + id_cp, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                $("#editMatkulModal").modal('show');
                $("#editMatkulModalLabel").html('Edit Cp Mata Kuliah');

                $("#id_cp").val(data['id_cp'])
                $("#kd_mk_update").val(data['kd_mk'])

                for (let i = 1; i <= <?= $data['auth']['cp_count'] ?>; i++) {
                    $("#cp_" + i + "_update").val(data['cp_' + i])
                }
            })
            .catch(error => {
                console.log(error);
            })
    }

    function deleteCp(id_cp) {
        Swal.fire({
            title: "Warning !",
            text: "Anda Yakin Ingin Menghapus Data CP Dari Mata Kuliah Ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= BASE_URL ?>Matkul/destroy/' + id_cp, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            title: "Berhasil",
                            text: "Data CP Berhasil Di Hapus",
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

    function editCpCount() {
        $("#updateCpCount").modal('show');
    }
</script>

<?php if ($data['auth']['cp_count'] == 0) { ?>
    <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Isi Jumlah CP</h1>
                </div>
                <div class="modal-body">
                    <div id="msg">
                    </div>
                    <input type="hidden" name="kd_jrs" id="kd_jrs" value="<?= $data['auth']['kd_jrs'] ?>">
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Minimal Target Pencapaian <span class="text-danger">*</span></label>
                        <input type="number" name="batas" id="batas" class="form-control" max="20" min="1" step="any" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Jumlah CP <span class="text-danger">*</span></label>
                        <input type="number" name="cp_count" id="cp_count" class="form-control" min="1" required>
                    </div>
                    <span class="text-danger mt-3">* Batas Maximal Pengisian CP Adalah 20</span>
                </div>
                <div class="modal-footer">
                    <button type="button" id="set" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#set").click(function() {
                let kd_jrs = $("#kd_jrs").val();
                let cp_count = $("#cp_count").val();
                let batas = $("#batas").val();

                if (cp_count > 20) {
                    $("#msg").html('<div class="alert alert-danger">Batas Maximial CP Hanya Boleh 20</div>');
                    setTimeout(() => {
                        $("#msg").html('');
                    }, 3000);
                } else if (cp_count < 1) {
                    $("#msg").html('<div class="alert alert-danger">Minimal CP Yang Harus Di Isi Adalah 1 - 20</div>');
                    setTimeout(() => {
                        $("#msg").html('');
                    }, 3000);
                } else {
                    $.ajax({
                        url: '<?= BASE_URL ?>Matkul/setCpCount',
                        method: 'POST',
                        data: {
                            kd_jrs: kd_jrs,
                            cp_count: cp_count,
                            batas: batas
                        },
                        dataType: 'json',
                        success: function(data) {
                            $("#exampleModal").modal('hide');
                            setTimeout(() => {
                                window.location.reload()
                            }, 1500);
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    })
                }
            })
        })
        window.onload = function() {
            $("#exampleModal").modal('show');
        }
    </script>
<?php }; ?>