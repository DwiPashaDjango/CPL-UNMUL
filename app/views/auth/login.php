<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Libs CSS -->
    <link href="<?= BASE_URL ?>libs/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>libs/dropzone/dist/dropzone.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>libs/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet" />
    <link href="<?= BASE_URL ?>libs/prismjs/themes/prism-okaidia.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>css/theme.min.css">
    <title>Login</title>
</head>

<body class="bg-light">
    <!-- container -->
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center g-0 min-vh-100">
            <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
                <!-- Card -->
                <?php Flasher::validationFlash() ?>
                <?php Flasher::flash() ?>
                <div class="card smooth-shadow-md">
                    <!-- Card body -->
                    <div class="card-body p-6">
                        <div class="mb-4">
                            <a href="<?= BASE_URL ?>"><img src="<?= BASE_URL ?>images/logo.png" width="100" class="mb-2" alt=""></a>
                            <p class="mb-6">Silahkan Login Untuk Menggunakan Aplikasi CPL.</p>
                        </div>
                        <!-- Form -->
                        <form action="<?= BASE_URL ?>Auth/login" method="post">
                            <!-- Username -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Nidn or email</label>
                                <input type="text" id="username" class="form-control" name="username" placeholder="Nidn or email here">
                            </div>
                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" class="form-control" name="password" placeholder="**************">
                            </div>
                            <div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                                <div class="mt-4">
                                    <div>
                                        <center>
                                            <a href="javascript:void(0)" class="text-inherit fs-5">Copyrigth &copy; Sistem CPL <?= date('Y') ?></a>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <!-- Libs JS -->
    <script src="<?= BASE_URL ?>libs/jquery/dist/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>libs/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?= BASE_URL ?>libs/feather-icons/dist/feather.min.js"></script>
    <script src="<?= BASE_URL ?>libs/prismjs/prism.js"></script>
    <script src="<?= BASE_URL ?>libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="<?= BASE_URL ?>libs/dropzone/dist/min/dropzone.min.js"></script>
    <script src="<?= BASE_URL ?>libs/prismjs/plugins/toolbar/prism-toolbar.min.js"></script>
    <script src="<?= BASE_URL ?>libs/prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>
    <!-- Theme JS -->
    <script src="<?= BASE_URL ?>js/theme.min.js"></script>
</body>

</html>