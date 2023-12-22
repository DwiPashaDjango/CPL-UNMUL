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
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card ">
                <!-- card body -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Mahasiswa</th>
                                    <th class="text-center">NIM</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Jurusan</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($data['mahasiswa'] as $mhs) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td>
                                            <a href="<?= BASE_URL ?>Lulusan/show/<?= $mhs['id_mhs'] ?>"><?= $mhs['name'] ?></a>
                                        </td>
                                        <td class="text-center"><?= $mhs['nrp'] ?></td>
                                        <td class="text-center"><?= $mhs['email'] ?></td>
                                        <td class="text-center"><?= $mhs['name_jurusan'] ?></td>
                                        <td class="text-center">
                                            <a href="<?= BASE_URL ?>Lulusan/show/<?= $mhs['id_mhs'] ?>" class="btn btn-outline-info btn-sm"><i class="bi bi-eye"></i></a>
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

<script src="<?= BASE_URL ?>libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#table").DataTable();
    })
</script>