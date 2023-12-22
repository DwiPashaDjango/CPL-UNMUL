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
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 mt-6">
            <!-- card -->
            <?php Flasher::validationFlash() ?>
            <div class="card ">
                <div class="card-header bg-white py-4">
                    <a href="<?= BASE_URL ?>Users/dosen" class="btn btn-secondary">
                        <bi class="bi-arrow-left"></bi>
                    </a>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>Users/createDosen" method="post">
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
                        <div class="form-group mb-3">
                            <label for="" class="mb-2">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <button class="btn btn-primary" style="float: right;">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>