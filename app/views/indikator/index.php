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
                        <a href="javascript:void(0)" id="create" class="btn btn-white">Tambah Nilai Indikator</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-md-12 mt-6">
            <!-- card -->
            <?php Flasher::flash() ?>
            <?php Flasher::validationFlash() ?>
            <div class="card ">
                <!-- card body -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Rentang Nilai</th>
                                    <th>Bobot Huruf</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data['indikator'])) { ?>
                                    <?php $no = 1;
                                    foreach ($data['indikator'] as $ind) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $ind['rentang_awal'] ?> - <?= $ind['rentang_akhir'] ?></td>
                                            <td><?= $ind['bobot_huruf'] ?></td>
                                            <td>
                                                <div class="dropdown dropstart">
                                                    <a class="text-muted text-primary-hover" href="#" role="button" id="dropdownTeamOne" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="icon-xxs" data-feather="more-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownTeamOne">
                                                        <a class="dropdown-item" onclick="showIndikator(<?= $ind['id_indikator'] ?>)" href="javascript:void(0)">Edit</a>
                                                        <a class="dropdown-item" onclick="deleteIndikator(<?= $ind['id_indikator'] ?>);" href="javascript:void(0)">Hapus</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php } else { ?>
                                    <td colspan="4">Tidak Ada Data Indikator Nilai</td>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalIndikator" tabindex="-1" aria-labelledby="modalIndikatorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalIndikatorLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Indikator/store" method="post">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Rentang Nilai Awal <span class="text-danger">*</span></label>
                        <input type="number" name="rentang_awal" id="rentang_awal" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Rentang Nilai Akhir <span class="text-danger">*</span></label>
                        <input type="number" name="rentang_akhir" id="rentang_akhir" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Nilai Huruf <span class="text-danger">*</span></label>
                        <input type="text" name="bobot_huruf" id="bobot_huruf" class="form-control">
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

<div class="modal fade" id="editModalIndikator" tabindex="-1" aria-labelledby="editModalIndikatorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalIndikatorLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Indikator/update" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id_indikator_update" id="id_indikator_update">
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Rentang Nilai Awal <span class="text-danger">*</span></label>
                        <input type="number" name="rentang_awal_update" id="rentang_awal_update" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Rentang Nilai Akhir <span class="text-danger">*</span></label>
                        <input type="number" name="rentang_akhir_update" id="rentang_akhir_update" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Nilai Huruf <span class="text-danger">*</span></label>
                        <input type="text" name="bobot_huruf_update" id="bobot_huruf_update" class="form-control">
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

<script src="<?= BASE_URL ?>libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#create").click(function() {
            $("#modalIndikator").modal('show');
            $("#modalIndikatorLabel").html('Tambah Data Nilai Indikator');
        })
    });

    function showIndikator(id_indikator) {
        fetch('<?= BASE_URL ?>Indikator/show/' + id_indikator, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                $("#editModalIndikator").modal('show');
                $("#editModalIndikatorLabel").html('Edit Nilai Indikator');

                $("#id_indikator_update").val(data['id_indikator']);
                $("#rentang_awal_update").val(data['rentang_awal']);
                $("#rentang_akhir_update").val(data['rentang_akhir']);
                $("#bobot_huruf_update").val(data['bobot_huruf']);
            })
            .catch(error => {
                console.log(error);
            })
    }

    function deleteIndikator(id_indikator) {
        Swal.fire({
            title: "Warning !",
            text: "Anda yakin ingin menghapus data nilai indikator ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= BASE_URL ?>Indikator/destroy/' + id_indikator, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            title: "Barhasil",
                            text: "Berhasil Menghapus Data Nilai Indikator.",
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