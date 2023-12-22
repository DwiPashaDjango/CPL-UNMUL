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
        <?php if ($data['auth']['roles'] == 'admin') : ?>
            <div class="col-xl-12 col-lg-12 col-md-12 col-12 mt-6">
                <div class="alert alert-info">
                    Selamat Datang <b><?= $data['auth']['name'] ?></b>
                </div>
            </div>
        <?php else : ?>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card ">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-0">Jumlah Mahasiswa</h4>
                            </div>
                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                <i class="bi bi-people fs-4"></i>
                            </div>
                        </div>
                        <!-- project number -->
                        <div>
                            <h1 class="fw-bold"><?= $data['mhs_active_count'][0]['total'] ?></h1>
                            <p class="mb-0 text-end">
                                <a href="<?= BASE_URL ?>Penilaian_CPL">
                                    Selengkapnya <i class="bi bi-arrow-right"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card ">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-0">Jumlah Lulusan</h4>
                            </div>
                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                <i class="bi bi-person-check fs-4"></i>
                            </div>
                        </div>
                        <!-- project number -->
                        <div>
                            <h1 class="fw-bold"><?= $data['mhs_lulus_count'][0]['total'] ?></h1>
                            <p class="mb-0 text-end">
                                <a href="<?= BASE_URL ?>Lulusan">
                                    Selengkapnya <i class="bi bi-arrow-right"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card ">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-0">Jumlah Mata Kuliah</h4>
                            </div>
                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                <i class="bi bi-book-fill fs-4"></i>
                            </div>
                        </div>
                        <!-- project number -->
                        <div>
                            <h1 class="fw-bold"><?= $data['count_mk_by_jrs'][0]['total'] ?></h1>
                            <p class="mb-0 text-end">
                                <a href="<?= BASE_URL ?>Mata_Kuliah">
                                    Selengkapnya <i class="bi bi-arrow-right"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card ">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-0">Jumlah CP (Capaian Pembelajaran)</h4>
                            </div>
                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                <i class="bi bi-bullseye fs-4"></i>
                            </div>
                        </div>
                        <!-- project number -->
                        <div>
                            <h1 class="fw-bold"><?= $data['auth']['cp_count'] ?></h1>
                            <p class="mb-0 text-end">
                                <a href="<?= BASE_URL ?>Matkul">
                                    Selengkapnya <i class="bi bi-arrow-right"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>