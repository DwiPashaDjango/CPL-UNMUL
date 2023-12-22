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
                        <a href="<?= BASE_URL ?>Users/dosenCreate" class="btn btn-white">Tambah Dosen</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 mt-6">
            <!-- card -->
            <?php Flasher::flash() ?>
            <?php Flasher::validationFlash() ?>
            <div class="card ">
                <!-- card body -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" style="width: 100%;" id="table">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Lengkap</th>
                                    <th class="text-center">Nidn</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Jurusan</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($data['user_dosen'] as $dsn) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $dsn['name'] ?></td>
                                        <td><?= $dsn['nidn'] ?></td>
                                        <td><?= $dsn['email'] ?></td>
                                        <td><?= $dsn['kd_jrs'] ?> - <?= $dsn['name_jurusan'] ?></td>
                                        <td>
                                            <div class="dropdown dropstart">
                                                <a class="text-muted text-primary-hover" href="#" role="button" id="dropdownTeamOne" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="icon-xxs" data-feather="more-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownTeamOne">
                                                    <a class="dropdown-item" onclick="showDosen(<?= $dsn['id_user'] ?>)" href="javascript:void(0)">Edit</a>
                                                    <a class="dropdown-item" onclick="resetpw(<?= $dsn['id_user'] ?>)" href="javascript:void(0)">Reset Password</a>
                                                    <a class="dropdown-item" onclick="deleteDosen(<?= $dsn['id_user'] ?>);" href="javascript:void(0)">Hapus</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php }; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editDosenModal" tabindex="-1" aria-labelledby="editDosenModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editDosenModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Users/ubahDosen" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id_user" id="id_user">
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Nidn <span class="text-danger">*</span></label>
                        <input type="number" name="nidn" id="nidn" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Email Addres <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Jurusan <span class="text-danger">*</span></label>
                        <select name="kd_jrs" id="kd_jrs" class="form-control">
                            <option value="">- Pilih -</option>
                            <?php foreach ($data['jurusan'] as $jrs) { ?>
                                <option value="<?= $jrs['kd_jrs'] ?>"><?= $jrs['name_jurusan'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="update">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="resetPassword" tabindex="-1" aria-labelledby="resetPasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="resetPasswordLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Users/resetPassword" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id_user_pw" id="id_user_pw">
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">New Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_update" id="password_update" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="update_pw">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#table").DataTable();

    })

    function showDosen(id_user) {
        fetch('<?= BASE_URL ?>Users/showDosen/' + id_user, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                $("#editDosenModal").modal('show');
                $("#editDosenModalLabel").html(data['name']);

                $("#id_user").val(data['id_user']);
                $("#nidn").val(data['nidn']);
                $("#name").val(data['name']);
                $("#email").val(data['email']);
                $("#kd_jrs").val(data['kd_jrs'])
            })
            .catch(error => {
                console.log(error);
            })
    }

    function deleteDosen(id_user) {
        Swal.fire({
            title: 'Warning !',
            text: "Anda Yakin Ingin Menghapus Data Dosen Ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= BASE_URL ?>Users/destroyDosen/' + id_user, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                        setTimeout(() => {
                            window.location.reload()
                        }, 2000);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        })
    }

    function resetpw(id_user) {
        $.ajax({
            url: '<?= BASE_URL ?>Users/showDosen/' + id_user,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $("#resetPassword").modal('show');
                $("#resetPasswordLabel").html('Reset Password');
                $("#id_user_pw").val(data.id_user);
            },
            error: function(err) {
                console.log(err);
            }
        })
    }
</script>