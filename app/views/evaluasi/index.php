<!-- Container fluid -->
<form action="<?= BASE_URL ?>Evaluasi/GenerateEvaluasi" method="post">
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
                            <button type="submit" class="btn btn-white">Evaluasi</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-12 mt-6">
                <?php Flasher::validationFlash() ?>
                <div class="card mb-6">
                    <div class="card-header">
                        <b>Pilih Mahasiswa Yang Akan Di Evaluasi Capaian Lulusannya</b>
                    </div>
                    <!-- card body -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table" style="width: 100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">Action</th>
                                        <th>Nama Mahasiswa</th>
                                        <th class="text-center">NIM</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Jurusan</th>
                                        <th class="text-center">Tahun Angkatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['mhs'] as $mhs) : ?>
                                        <tr>
                                            <td class="text-center">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="id_mhs[]" id="id_mhs" value="<?= $mhs['id_mhs'] ?>">
                                                </div>
                                            </td>
                                            <td><?= $mhs['name'] ?></td>
                                            <td class="text-center"><?= $mhs['nrp'] ?></td>
                                            <td class="text-center"><?= $mhs['email'] ?></td>
                                            <td class="text-center"><?= $mhs['name_jurusan'] ?></td>
                                            <td class="text-center">T.A - <?= $mhs['angkatan'] ?></td>
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
</form>

<script src="<?= BASE_URL ?>libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#table").DataTable();
    })

    function click() {
        alert('Oke');
    }
</script>