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
                        <a href="javascript:void(0)" class="btn btn-white" data-bs-toggle="modal" data-bs-target="#addMk">Tambah Mata Kuliah</a>
                        <a href="javascript:void(0)" class="btn btn-white" data-bs-toggle="modal" data-bs-target="#modalMk">Import Data Mata Kuliah</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-md-12 mt-6">
            <?php Flasher::flash() ?>
            <?php Flasher::validationFlash() ?>
            <!-- card -->
            <div class="card ">
                <!-- card body -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Kode Mata Kuliah</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th class="text-center">SKS</th>
                                    <th class="text-center">Jurusan</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data['mata_kuliah'])) { ?>
                                    <?php foreach ($data['mata_kuliah'] as $mk) : ?>
                                        <tr>
                                            <td class="text-center"><?= $mk['kd_mk'] ?></td>
                                            <td><?= $mk['nm_mk'] ?></td>
                                            <td class="text-center"><?= $mk['sks'] ?></td>
                                            <td class="text-center"><?= $mk['name_jurusan'] ?></td>
                                            <td class="text-center">
                                                <div class="dropdown dropstart">
                                                    <a class="text-muted text-primary-hover" href="#" role="button" id="dropdownTeamOne" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="icon-xxs" data-feather="more-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownTeamOne">
                                                        <a class="dropdown-item" onclick="showMk('<?= $mk['kd_mk'] ?>')" href="javascript:void(0)">Edit</a>
                                                        <a class="dropdown-item" onclick="deleteMk('<?= $mk['id_mk'] ?>');" href="javascript:void(0)">Hapus</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalMk" tabindex="-1" aria-labelledby="modalMkLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalMkLabel">Import Data Mata Kuliah</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Mata_Kuliah/import" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">File <span class="text-danger">*</span></label>
                        <input type="file" name="file" id="file" class="form-control" required accept=".xls, .xlsx">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?= BASE_URL ?>_file/template_mata_kuliah.xlsx" download="" class="btn btn-success">Download Template</a>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editMkModal" tabindex="-1" aria-labelledby="editMkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editMkModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Mata_Kuliah/update" method="post">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Kode Mata Kuliah <span class="text-danger">*</span></label>
                        <input type="text" name="kd_mk" id="kd_mk" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Nama Mata Kuliah <span class="text-danger">*</span></label>
                        <input type="text" name="nm_mk" id="nm_mk" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Jumlah SKS <span class="text-danger">*</span></label>
                        <input type="number" name="sks" id="sks" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addMk" tabindex="-1" aria-labelledby="addMkLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMkLabel">Tambah Data Mata Kuliah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Mata_Kuliah/store" method="post">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Kode Mata Kuliah <span class="text-danger">*</span></label>
                        <input type="text" name="kd_mk_add" id="kd_mk_add" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Nama Mata Kuliah <span class="text-danger">*</span></label>
                        <input type="text" name="nm_mk_add" id="nm_mk_add" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Jumlah SKS <span class="text-danger">*</span></label>
                        <input type="number" name="sks_add" id="sks_add" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#table").DataTable()
    })

    function showMk(kd_mk) {
        fetch('<?= BASE_URL ?>Mata_Kuliah/show/' + kd_mk, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                $("#editMkModal").modal('show');
                $("#editMkModalLabel").html(data['kd_mk'] + ' - ' + data['nm_mk']);

                $("#kd_mk").val(data['kd_mk']);
                $("#nm_mk").val(data['nm_mk']);
                $("#sks").val(data['sks'])
            })
            .catch(error => {
                console.log(error);
            })
    }

    function deleteMk(id_mk) {
        Swal.fire({
            title: "Warning !",
            text: "Anda Yakin Ingin Menghapus Data Mata Kuliah Ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= BASE_URL ?>Mata_Kuliah/destroy/' + id_mk, {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            title: "Berhasil",
                            text: "Berhasil Menghapus Mata Kuliah",
                            icon: "success"
                        });
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        });
    }
</script>