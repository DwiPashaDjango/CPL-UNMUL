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
                        <a href="javascript:void(0)" id="modal" class="btn btn-white">Tambah</a>
                        <a href="javascript:void(0)" id="create" class="btn btn-white">Import Data Jurusan</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 mt-6">
            <?php Flasher::flash() ?>
            <?php Flasher::validationFlash() ?>
            <!-- card -->
            <div class="card ">
                <!-- card body -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" style="width: 100%;" id="table">
                            <thead class="table-light">
                                <tr>
                                    <td class="text-center">No</td>
                                    <td class="text-center">Kode Jurusan</td>
                                    <td class="text-center">Nama Jurusan</td>
                                    <td class="text-center">Minimal Target</td>
                                    <td class="text-center">Jumlah CP</td>
                                    <td class="text-center">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($data['jurusan'] as $jrs) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $jrs['kd_jrs'] ?></td>
                                        <td><?= $jrs['name_jurusan'] ?></td>
                                        <td><?= number_format($jrs['batas'], 2) ?>%</td>
                                        <td>
                                            <?php if ($jrs['cp_count'] != 0) : ?>
                                                <?= $jrs['cp_count'] ?>
                                            <?php else : ?>
                                                Belum Mengisi
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <div class="dropdown dropstart">
                                                <a class="text-muted text-primary-hover" href="#" role="button" id="dropdownTeamOne" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="icon-xxs" data-feather="more-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownTeamOne">
                                                    <a class="dropdown-item" onclick="addCp('<?= $jrs['kd_jrs'] ?>')" href="javascript:void(0)">Tambah CP Jurusan</a>
                                                    <a class="dropdown-item" onclick="showJrs('<?= $jrs['kd_jrs'] ?>')" href="javascript:void(0)">Edit</a>
                                                    <a class="dropdown-item" onclick="deleteJrs('<?= $jrs['kd_jrs'] ?>');" href="javascript:void(0)">Hapus</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createModalLabel">Tambah Data Jurusan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Jurusan/import" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="mb-2">File <span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control" accept=".xls, .xlsx" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?= BASE_URL ?>_file/template_jurusan.xlsx" download="" class="btn btn-success">Download Template</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Jurusan/update" method="post">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Kode Jurusan <span class="text-danger">*</span></label>
                        <input type="text" name="kd_jrs" id="kd_jrs" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="mb-2">Nama Jurusan <span class="text-danger">*</span></label>
                        <input type="text" name="name_jurusan" id="name_jurusan" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addCp" tabindex="-1" aria-labelledby="addCpLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addCpLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Jurusan/addCP" method="post">
                <div class="modal-body">
                    <input type="hidden" name="kd_jrs_cp" id="kd_jrs_cp" class="form-control">
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Minimal Target CP Mahasiswa <span class="text-danger">*</span></label>
                        <input type="number" name="batas" id="batas" class="form-control" max="100" min="1" step="any">
                    </div>
                    <div class="form-group">
                        <label for="" class="mb-2">Jumlah CP <span class="text-danger">*</span></label>
                        <input type="number" name="cp_count" id="cp_count" class="form-control" max="20" min="1">
                    </div>
                    <br>
                    <span class="text-danger">* Maximal Jumlah CP Ada 20</span>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addJrs" tabindex="-1" aria-labelledby="addJrsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addJrsLabel">Tambah Data Jurusan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Jurusan/addJurusanOne" method="post">
                <div class="modal-body">
                    <span class="text-danger">* Kode Jurusan Akan Tergenerate Secara Otomatis</span>
                    <br>
                    <br>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Nama Jurusan <span class="text-danger">*</span></label>
                        <input type="text" name="name_jurusan" id="name_jurusan" class="form-control" max="100" min="1" step="any">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#table").DataTable();
        $("#create").click(function() {
            $("#createModal").modal('show');
        });

        $("#modal").click(function() {
            $("#addJrs").modal('show');
        });
    })

    function showJrs(kd_jrs) {
        fetch('<?= BASE_URL ?>Jurusan/show/' + kd_jrs, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                $("#editModal").modal('show');
                $("#editModalLabel").html(data['kd_jrs'] + ' - ' + data['name_jurusan']);

                $("#kd_jrs").val(data['kd_jrs']);
                $("#name_jurusan").val(data['name_jurusan']);
            })
            .catch(error => {
                console.log(error);
            })
    }

    function deleteJrs(kd_jrs) {
        Swal.fire({
            title: "Warning !",
            text: "Anda Yakin Ingin Menghapus Data Ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= BASE_URL ?>Jurusan/destroy/' + kd_jrs, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            title: "Barhasil",
                            text: "Data Jurusan Berhasil Di Hapus.",
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

    function addCp(kd_jrs) {
        fetch('<?= BASE_URL ?>Jurusan/show/' + kd_jrs, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                $("#addCp").modal('show');
                $("#addCpLabel").html('Tambah Jumlah CP Pada Jurusan - ' + data['name_jurusan']);

                $("#kd_jrs_cp").val(data['kd_jrs']);
                $("#batas").val(data['batas']);
                $("#cp_count").val(data['cp_count']);
            })
            .catch(error => {
                console.log(error);
            })
    }
</script>