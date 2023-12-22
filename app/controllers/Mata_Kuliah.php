<?php

use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Base;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Floor;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Mata_Kuliah extends Controller
{
    public function __construct()
    {
        Middleware::auth();
    }

    public function index()
    {
        try {
            $data['title'] = 'Data Mata Kuliah';
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $kd_jrs = $data['auth']['kd_jrs'];

            $data['mata_kuliah'] = $this->model('Mata_Kuliah_Model')->getAllMkByJrs($kd_jrs);
            // var_dump($data['mata_kuliah']);
            // die;

            // var_dump($data['mata_kuliah']);
            // die;
            $this->view('layouts/header', $data);
            $this->view('layouts/sidebar', $data);
            $this->view('layouts/topnav', $data);
            $this->view('mata_kuliah/index', $data);
            $this->view('layouts/footer', $data);
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function show($kd_mk)
    {
        $data = $this->model('Mata_Kuliah_Model')->getMkByKd($kd_mk);
        echo json_encode($data);
    }

    public function store()
    {
        $data['auth']  = $this->model('Auth_Model')->getUserLogin();
        $errors = [];

        if (empty($_POST['kd_mk_add'])) {
            $errors['kd_mk_add'] = "Masukan Kode Mata Kuliah";
        }

        if (empty($_POST['nm_mk_add'])) {
            $errors['nm_mk_add'] = "Masukan Nama Mata Kuliah";
        }

        if (empty($_POST['sks_add'])) {
            $errors['sks_add'] = "Masukan Jumlah SKS";
        }

        if (empty($errors)) {
            $data = [
                "kd_mk" => $_POST['kd_mk_add'],
                "nm_mk" => $_POST['nm_mk_add'],
                "sks"   => $_POST['sks_add'],
                "kd_jrs" => $data['auth']['kd_jrs']
            ];

            $this->model('Mata_Kuliah_Model')->insertOneMk($data);
            Flasher::setFlash('Berhasil Menambahkan Data ', ' Mata Kuliah Baru.', 'success');
            header("Location: " . BASE_URL . "Mata_Kuliah");
            exit;
        } else {
            Flasher::setValidation($errors);
            header("Location: " . BASE_URL . "Mata_Kuliah");
            exit;
        }
    }

    public function import()
    {
        try {
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $kd_jrs = $data['auth']['kd_jrs'];

            $file = $_FILES['file']['tmp_name'];

            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet()->toArray();

            $data = array();
            for ($row = 1; $row < count($worksheet); $row++) {
                $kd_mk = $worksheet[$row][0];
                $nm_mk = $worksheet[$row][1];
                $sks = $worksheet[$row][2];

                $data[] = array(
                    "kd_mk" => $kd_mk,
                    "nm_mk" => $nm_mk,
                    "sks" => $sks,
                    "kd_jrs" => $kd_jrs
                );
            }

            $this->model('Mata_Kuliah_Model')->importMk($data);

            Flasher::setFlash('Berhasil Mengimport Data ', 'Mata Kuliah', 'success');
            header("Location: " . BASE_URL . "Mata_Kuliah");
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function update()
    {
        $errors = [];

        if (empty($_POST['nm_mk'])) {
            $errors['nm_mk'] = "Masukan Nama Mata Kuliah";
        }

        if (empty($_POST['sks'])) {
            $errors['sks'] = "Masukan Jumlah SKS";
        }

        if (empty($errors)) {
            $this->model('Mata_Kuliah_Model')->updateMk($_POST);

            Flasher::setFlash('Berhasil Mengubah ', 'Mata Kuliah.', 'success');
            header("Location:" . BASE_URL . "Mata_Kuliah");
            exit;
        } else {
            Flasher::setValidation($errors);
            header("Location:" . BASE_URL . "Mata_Kuliah");
            exit;
        }
    }

    public function destroy($id_mk)
    {
        if ($this->model('Mata_Kuliah_Model')->deleteMkAndCP($id_mk) > 0) {
            echo json_encode("Berhasil");
        } else {
            echo json_encode("Gagal");
        }
    }
}
