<!-- Sidebar -->
<nav class="navbar-vertical navbar">
    <div class="nav-scroller">
        <!-- Brand logo -->
        <a class="<?= BASE_URL ?>Dashboard" href="#l">
            <center>
                <img width="80" src="<?= BASE_URL ?>images/logo.png" class="py-2" alt="">
                <div class="text-white">
                    <b>
                        Universitas Mulawarman
                        <br>
                        Fakultas Pertanian
                        <?php if ($data['auth']['roles'] != 'admin') : ?>
                            <br>
                            Jurusan <?= $data['auth']['name_jurusan'] ?>
                        <?php endif ?>
                    </b>
                </div>
            </center>
        </a>
        <hr>
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">
            <li class="nav-item">
                <a class="nav-link has-arrow <?= (strpos($_SERVER['REQUEST_URI'], '/Dashboard') !== false) ? 'active' : '' ?>" href="<?= BASE_URL ?>Dashboard">
                    <i data-feather="home" class="nav-icon icon-xs me-2"></i>
                    Dashboard
                </a>
            </li>
            <?php if ($data['auth']['roles'] == 'admin') { ?>
                <!-- Nav item -->
                <li class="nav-item">
                    <div class="navbar-heading">Data Master</div>
                </li>
                <!-- Nav item -->
                <li class="nav-item">
                    <a class="nav-link has-arrow collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#navPages" aria-expanded="false" aria-controls="navPages">
                        <i data-feather="layers" class="nav-icon icon-xs me-2"></i>
                        Data Users
                    </a>
                    <div id="navPages" class="collapse " data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], 'Users') !== false) ? 'active' : '' ?>" href="<?= BASE_URL ?>Users">
                                    Data Admin
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link has-arrow <?= (strpos($_SERVER['REQUEST_URI'], 'Users/dosen') !== false) ? 'active' : '' ?>" href="<?= BASE_URL ?>Users/dosen">
                                    Data Dosen
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link has-arrow <?= (strpos($_SERVER['REQUEST_URI'], '/Jurusan') !== false) ? 'active' : '' ?>" href="<?= BASE_URL ?>Jurusan">
                        <i data-feather="list" class="nav-icon icon-xs me-2"></i>
                        Data Jurusan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link has-arrow <?= (strpos($_SERVER['REQUEST_URI'], '/Indikator') !== false) ? 'active' : '' ?>" href="<?= BASE_URL ?>Indikator">
                        <i data-feather="list" class="nav-icon icon-xs me-2"></i>
                        Data Indikator Nilai
                    </a>
                </li>
            <?php }; ?>
            <?php if ($data['auth']['roles'] == 'kaprodi') { ?>
                <li class="nav-item">
                    <div class="navbar-heading">Matrix</div>
                </li>
                <li class="nav-item">
                    <a class="nav-link has-arrow <?= (strpos($_SERVER['REQUEST_URI'], '/Mata_Kuliah') !== false) ? 'active' : '' ?>" href="<?= BASE_URL ?>Mata_Kuliah">
                        <i data-feather="list" class="nav-icon icon-xs me-2"></i>
                        Data Mata Kuliah
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link has-arrow <?= (strpos($_SERVER['REQUEST_URI'], '/Matkul') !== false) ? 'active' : '' ?>" href="<?= BASE_URL ?>Matkul">
                        <i data-feather="list" class="nav-icon icon-xs me-2"></i>
                        Matrix Mata Kuliah
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link has-arrow <?= (strpos($_SERVER['REQUEST_URI'], '/Pembobotan') !== false) ? 'active' : '' ?>" href="<?= BASE_URL ?>Pembobotan">
                        <i data-feather="list" class="nav-icon icon-xs me-2"></i>
                        Matrix Pembobotan MK
                    </a>
                </li>
                <li class="nav-item">
                    <div class="navbar-heading">Data Mahasiswa</div>
                </li>
                <li class="nav-item">
                    <a class="nav-link has-arrow <?= (strpos($_SERVER['REQUEST_URI'], '/Mahasiswa') !== false) ? 'active' : '' ?>" href="<?= BASE_URL ?>Mahasiswa">
                        <i data-feather="users" class="nav-icon icon-xs me-2"></i>
                        Data Mahasiswa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link has-arrow <?= (strpos($_SERVER['REQUEST_URI'], '/Nilai') !== false) ? 'active' : '' ?>" href="<?= BASE_URL ?>Nilai">
                        <i data-feather="list" class="nav-icon icon-xs me-2"></i>
                        Data Nilai Mahasiswa
                    </a>
                </li>
                <li class="nav-item">
                    <div class="navbar-heading">Rekapitulasi</div>
                </li>
                <li class="nav-item">
                    <a class="nav-link has-arrow <?= (strpos($_SERVER['REQUEST_URI'], '/Penilaian_CPL') !== false) ? 'active' : '' ?>" href="<?= BASE_URL ?>Penilaian_CPL">
                        <i data-feather="list" class="nav-icon icon-xs me-2"></i>
                        Matrix Penilaian CPL
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link has-arrow <?= (strpos($_SERVER['REQUEST_URI'], '/Evaluasi') !== false) ? 'active' : '' ?>" href="<?= BASE_URL ?>Evaluasi">
                        <i data-feather="list" class="nav-icon icon-xs me-2"></i>
                        Evaluasi Penilaian CPL
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link has-arrow <?= (strpos($_SERVER['REQUEST_URI'], '/Lulusan') !== false) ? 'active' : '' ?>" href="<?= BASE_URL ?>Lulusan">
                        <i data-feather="list" class="nav-icon icon-xs me-2"></i>
                        Data Mahasiswa Lulus
                    </a>
                </li>
            <?php }; ?>
        </ul>
    </div>
</nav>
<div id="page-content">