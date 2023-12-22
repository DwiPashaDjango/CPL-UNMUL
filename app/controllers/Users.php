<?php

class Users extends Controller
{
    public function __construct()
    {
        Middleware::auth();
    }

    public function index()
    {
        try {
            $data['title'] = 'Data Admin';
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();

            $data['users_admin'] = $this->model('Users_Model')->getUsersAdmin();

            $this->view('layouts/header', $data);
            $this->view('layouts/sidebar', $data);
            $this->view('layouts/topnav', $data);
            $this->view('users/admin/index', $data);
            $this->view('layouts/footer');
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function adminCreate()
    {
        try {
            $data['title'] = 'Tambah Data Admin';
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();

            $this->view('layouts/header', $data);
            $this->view('layouts/sidebar', $data);
            $this->view('layouts/topnav', $data);
            $this->view('users/admin/create', $data);
            $this->view('layouts/footer');
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function showAdmin($id_user)
    {
        $data = $this->model('Users_Model')->getAdminById($id_user);
        echo json_encode($data);
    }

    public function storeAdmin()
    {
        try {
            $errors = [];

            if (empty($_POST['name'])) {
                $errors['name'] = 'Masukan Nama Lengkap';
            }

            if (empty($_POST['email'])) {
                $errors['email'] = 'Masukan Email Addres';
            }

            if (empty($_POST['password'])) {
                $errors['password'] = 'Masukan Password';
            }

            if (empty($errors)) {
                $this->model('Users_Model')->createAdmin($_POST);
                Flasher::setFlash('Berhasil ', 'Menambahkan Data Admin Baru.', 'success');
                header('Location: ' . BASE_URL . 'Users');
                exit;
            } else {
                Flasher::setValidation($errors);
                header("Location: " . BASE_URL . 'Users/adminCreate');
                exit;
            }
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function updateAdmin()
    {
        $data = $this->model('Users_Model')->updateAdmin($_POST);
        echo json_encode($data);
    }

    public function destroyAdmin($id_user)
    {
        if ($this->model('Users_Model')->deleteAdmin($id_user) > 0) {
            echo json_encode("Berhasil");
        } else {
            echo json_encode("Gagal");
        }
    }

    public function dosen()
    {
        try {
            $data['title'] = 'Data Dosen';
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();

            $data['jurusan'] = $this->model('Jurusan_Model')->getAllJurusan();
            $data['user_dosen'] = $this->model('Users_Model')->getAllDosen();

            $this->view('layouts/header', $data);
            $this->view('layouts/sidebar', $data);
            $this->view('layouts/topnav', $data);
            $this->view('users/dosen/index', $data);
            $this->view('layouts/footer');
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function dosenCreate()
    {
        try {
            $data['title'] = 'Tambah Data Dosen';
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();

            $data['jurusan'] = $this->model('Jurusan_Model')->getAllJurusan();

            $this->view('layouts/header', $data);
            $this->view('layouts/sidebar', $data);
            $this->view('layouts/topnav', $data);
            $this->view('users/dosen/create', $data);
            $this->view('layouts/footer');
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function showDosen($id_user)
    {
        $data = $this->model('Users_Model')->getDosenById($id_user);
        echo json_encode($data);
    }

    public function createDosen()
    {
        $errors = [];

        if (empty($_POST['nidn'])) {
            $errors['nidn'] = 'Masukan No Induk Dosen Nasional';
        }

        if (empty($_POST['name'])) {
            $errors['name'] = 'Masukan Nama Lengkap';
        }

        if (empty($_POST['email'])) {
            $errors['email'] = 'Masukan Email Addres';
        }

        if (empty($_POST['kd_jrs'])) {
            $errors['kd_jrs'] = 'Pilih Salah Satu Jurusan';
        }

        if (empty($_POST['password'])) {
            $errors['password'] = 'Masukan Password';
        }

        if (empty($errors)) {
            $this->model('Users_Model')->storeDosen($_POST);
            Flasher::setFlash('Berhasil Menambahkan ', 'Data Dosen Baru.', 'success');
            header("Location: " . BASE_URL . "Users/dosen");
            exit;
        } else {
            Flasher::setValidation($errors);
            header("Location: " . BASE_URL . "Users/showDosen");
            exit;
        }
    }

    public function ubahDosen()
    {
        try {
            $errors = [];

            if (empty($_POST['nidn'])) {
                $errors['nidn'] = 'Masukan No Induk Dosen Nasional';
            }

            if (empty($_POST['name'])) {
                $errors['name'] = 'Masukan Nama Lengkap';
            }

            if (empty($_POST['email'])) {
                $errors['email'] = 'Masukan Email Addres';
            }

            if (empty($_POST['kd_jrs'])) {
                $errors['kd_jrs'] = 'Pilih Salah Satu Jurusan';
            }

            if (empty($errors)) {
                $this->model('Users_Model')->updateDosen($_POST);
                Flasher::setFlash('Berhasil Mengubah ', 'Data Dosen.', 'success');
                header("Location: " . BASE_URL . "Users/dosen");
                exit;
            } else {
                Flasher::setValidation($errors);
                header("Location: " . BASE_URL . "Users/dosen");
                exit;
            }
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function destroyDosen($id_user)
    {
        if ($this->model('Users_Model')->deleteDosen($id_user) > 0) {
            echo json_encode("Berhasil");
        } else {
            echo json_encode("Gagal");
        }
    }
}
