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
                        <a href="javascript:void(0)" class="btn btn-white" id="import">Import Mahasiswa</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 mt-6">
            <!-- card -->
            <?php Flasher::flash() ?>
            <?php Flasher::validationFlash() ?>
            <div class="card mb-3">
                <!-- card body -->
                <div class="card-body">
                    <form action="<?= BASE_URL ?>Mahasiswa/searchAllMhs" method="post">
                        <div class="input-group mb-3">
                            <input type="search" name="search" class="form-control" placeholder="Search..." aria-label="Search..." aria-describedby="button-addon2">
                            <button type="submit" class="btn btn-primary" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="">Nama Lengkap</th>
                                    <th class="text-center">NRP</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Jurusan</th>
                                    <th class="text-center">Tahun Angkatan</th>
                                    <th class="text-center">Strata</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data['mahasiswa'])) : ?>
                                    <?php
                                    $no = ($data['pagination']['current_page'] - 1) * $data['pagination']['per_page'] + 1;
                                    foreach ($data['mahasiswa'] as $mhs) : ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $mhs['name'] ?></td>
                                            <td class="text-center"><?= $mhs['nrp'] ?></td>
                                            <td class="text-center"><?= $mhs['email'] ?></td>
                                            <td class="text-center"><?= $mhs['name_jurusan'] ?></td>
                                            <td class="text-center"><?= $mhs['angkatan'] ?></td>
                                            <td class="text-center"><?= $mhs['strata'] ?> - <?= $mhs['name_jurusan'] ?></td>
                                            <td class="text-center">
                                                <?php
                                                if ($mhs['status'] == 0) {
                                                    echo '<span class="badge bg-info p-2">Aktif</span>';
                                                } else {
                                                    echo '<span class="badge bg-success p-2">Lulus</span>';
                                                }

                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown dropstart">
                                                    <a class="text-muted text-primary-hover" href="#" role="button" id="dropdownTeamOne" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="icon-xxs" data-feather="more-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownTeamOne">
                                                        <a class="dropdown-item" onclick="showMhs(<?= $mhs['id_mhs'] ?>)" href="javascript:void(0)">Edit</a>
                                                        <a class="dropdown-item" onclick="deleteMhs(<?= $mhs['id_mhs'] ?>);" href="javascript:void(0)">Hapus</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak Ada Data Mahasiswa</td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (!empty($data['mahasiswa'])) : ?>
                        <div class="d-flex justify-content-start">
                            <nav>
                                <ul class="pagination">
                                    <?php if ($data['pagination']['current_page'] > 1) : ?>
                                        <li class="page-item"><a class="page-link" href="<?= BASE_URL ?>Mahasiswa/<?= $data['pagination']['current_page'] - 1; ?>">Previous</a></li>
                                    <?php endif; ?>

                                    <?php
                                    $totalPages = $data['pagination']['total_pages'];
                                    $currentPage = $data['pagination']['current_page'];
                                    if ($totalPages <= 10) {
                                        for ($i = 1; $i <= $totalPages; $i++) {
                                            echo '<li class="page-item"><a class="page-link" href="' . BASE_URL . 'Mahasiswa/' . $i . '">' . $i . '</a></li>';
                                        }
                                    } else {
                                        if ($currentPage <= 6) {
                                            for ($i = 1; $i <= 8; $i++) {
                                                echo '<li class="page-item"><a class="page-link" href="' . BASE_URL . 'Mahasiswa/' . $i . '">' . $i . '</a></li>';
                                            }
                                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                            echo '<li class="page-item"><a class="page-link" href="' . BASE_URL . 'Mahasiswa/' . $totalPages . '">' . $totalPages . '</a></li>';
                                        } else {
                                            echo '<li class="page-item"><a class="page-link" href="' . BASE_URL . 'Mahasiswa/1">1</a></li>';
                                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';

                                            $start = ($currentPage >= ($totalPages - 3)) ? ($totalPages - 8) : ($currentPage - 3);
                                            $end = ($currentPage >= ($totalPages - 3)) ? $totalPages : ($currentPage + 4);

                                            for ($i = $start; $i <= $end; $i++) {
                                                echo '<li class="page-item"><a class="page-link" href="' . BASE_URL . 'Mahasiswa/' . $i . '">' . $i . '</a></li>';
                                            }

                                            if ($end != $totalPages) {
                                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                                echo '<li class="page-item"><a class="page-link" href="' . BASE_URL . 'Mahasiswa/' . $totalPages . '">' . $totalPages . '</a></li>';
                                            }
                                        }
                                    }
                                    ?>
                                    <?php if ($data['pagination']['current_page'] < $data['pagination']['total_pages']) : ?>
                                        <li class="page-item"><a class="page-link" href="<?= BASE_URL ?>Mahasiswa/<?= $data['pagination']['current_page'] + 1; ?>">Next</a></li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="importModalLabel">Import Data Mahasiswa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Mahasiswa/import" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-control b-3">
                        <label for="" class="mb-2">File</label>
                        <input type="file" name="file" id="file" class="form-control" accept=".xls, .xlsx" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?= BASE_URL ?>_file/template_data_mhs.xlsx" download="" class="btn btn-success">Dwonload Template</a>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editMhsModal" tabindex="-1" aria-labelledby="editMhsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editMhsModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Mahasiswa/update" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id_mhs" id="id_mhs">
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">NRP <span class="text-danger">*</span></label>
                        <input type="text" name="nrp" id="nrp" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="update">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#table').DataTable();

        $("#import").click(function() {
            $("#importModal").modal('show');
        });
    })

    function showMhs(id_mhs) {
        fetch('<?= BASE_URL ?>Mahasiswa/show/' + id_mhs, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                $("#editMhsModal").modal('show');
                $("#editMhsModalLabel").html(data['name']);
                $("#id_mhs").val(data['id_mhs']);

                $("#name").val(data['name']);
                $("#nrp").val(data['nrp']);
                $("#email").val(data['email']);
                $("#kd_jrs").val(data['kd_jrs']);
            })
            .catch(error => {
                console.log(error);
            })
    }

    function deleteMhs(id_mhs) {
        Swal.fire({
            title: 'Warning !',
            text: "Anda Yakin Ingin Menghapus Data Mahasiswa Ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= BASE_URL ?>Mahasiswa/destroyMhs/' + id_mhs, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire(
                            'Deleted!',
                            'Berhasil Menghapus Data Mahasiswa.',
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
</script>