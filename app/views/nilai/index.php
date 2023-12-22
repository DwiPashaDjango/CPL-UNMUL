<!-- Container fluid -->
<style>
    th:first-child,
    td:first-child {
        position: sticky;
        left: 0;
    }

    .select2-container--open {
        z-index: 9999999;
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
                    <!-- <div>
                        <a href="#" class="btn btn-white">Create New Project</a>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 mt-6">
            <!-- card -->
            <div class="card mb-6">
                <!-- card body -->
                <div class="card-header">
                    <a href="javascript:void(0)" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-filter"></i> Filter</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="table" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Mahasiswa</th>
                                    <th class="text-center">NIM</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Jurusan</th>
                                    <th class="text-center">Tahun Angkatan</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($data['mahasiswa'] as $mhs) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $mhs['name'] ?></td>
                                        <td class="text-center"><?= $mhs['nrp'] ?></td>
                                        <td class="text-center"><?= $mhs['email'] ?></td>
                                        <td class="text-center"><?= $mhs['name_jurusan'] ?></td>
                                        <td class="text-center">T.A-<?= $mhs['angkatan'] ?></td>
                                        <td class="text-center">
                                            <?php if ($data['auth']['cp_count'] > 0) : ?>
                                                <a href="<?= BASE_URL ?>Nilai/show/<?= $mhs['id_mhs'] ?>" class="btn btn-outline-primary btn-sm">Set Nilai</a>
                                            <?php else : ?>
                                                <a href="javascript:void(0)" class=" btn btn-outline-primary btn-sm disabled">Set Nilai</a>
                                            <?php endif ?>
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

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Filter Berdasarkan Tahun Angkatan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASE_URL ?>Nilai/filterByAngkatan" method="post">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Pilih Tahun Angkatan <span class="text-danger">*</span></label>
                        <select name="year[]" id="year" class="form-control" multiple>
                            <?php
                            $currentYear = date('Y');
                            for ($i = $currentYear; $i >= $currentYear - 8; $i--) { ?>
                                <option value="<?= $i ?>">T.A-<?= $i ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#table").DataTable();

        $('#year').select2({
            width: 460,
            heigth: 500
        });
    })
</script>