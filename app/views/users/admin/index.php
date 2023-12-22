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
                        <a href="<?= BASE_URL ?>Users/adminCreate" class="btn btn-white">Tambah Admin</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 mt-6">
            <!-- card -->
            <?php Flasher::flash() ?>
            <div class="card ">
                <div class="card-body">
                    <div class="table-responsive-lg">
                        <table class="table table-bordered table-hover text-center" id="table" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <td class="text-center">No</td>
                                    <td class="text-center">Nama Lengkap</td>
                                    <td class="text-center">Email</td>
                                    <td class="text-center">Created At</td>
                                    <td class="text-center">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($data['users_admin'] as $adm) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $adm['name'] ?></td>
                                        <td><?= $adm['email'] ?></td>
                                        <td><?= date('d-F-Y', strtotime($adm['created_at'])) ?></td>
                                        <td>
                                            <div class="dropdown dropstart">
                                                <a class="text-muted text-primary-hover" href="#" role="button" id="dropdownTeamOne" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="icon-xxs" data-feather="more-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownTeamOne">
                                                    <a class="dropdown-item" onclick="showAdmin(<?= $adm['id_user'] ?>)" href="javascript:void(0)">Edit</a>
                                                    <a class="dropdown-item" onclick="deleteAdmin(<?= $adm['id_user'] ?>);" href="javascript:void(0)">Hapus</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_user" id="id_user">
                <div class="form-group mb-3">
                    <label for="" class="mb-2">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="" class="mb-2">Email Addres <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="update" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#table").DataTable();

        $("#update").click(function() {
            let id_user = $("#id_user").val();
            let name = $("#name").val();
            let email = $("#email").val();

            $.ajax({
                url: '<?= BASE_URL ?>Users/updateAdmin',
                method: 'POST',
                data: {
                    id_user: id_user,
                    name: name,
                    email: email
                },
                dataType: 'json',
                success: function(data) {
                    $("#exampleModal").modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Berhasil Mengubah Data Admin!',
                    })
                    setTimeout(() => {
                        window.location.reload()
                    }, 2000);
                },
                error: function(err) {
                    console.log(err);
                }
            })
        })
    });

    function showAdmin(id_user) {
        fetch('<?= BASE_URL ?>Users/showAdmin/' + id_user, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                $("#exampleModal").modal('show');
                $("#exampleModalLabel").html(data['name']);
                $("#id_user").val(data['id_user']);
                $("#name").val(data['name']);
                $("#email").val(data['email']);
            })
            .catch(error => {
                console.log(error);
            })
    }

    function deleteAdmin(id_user) {
        Swal.fire({
            title: 'Warning !',
            text: "Anda Yakin Akan Menghapus Data Ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= BASE_URL ?>Users/destroyAdmin/' + id_user, {
                        method: 'GET'
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Berhasil Menghapus Data Admin!',
                        })
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
</script>