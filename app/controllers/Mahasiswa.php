<?php

use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Base;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Mahasiswa extends Controller
{
    public function __construct()
    {
        Middleware::auth();
    }

    public function index($page = 1)
    {
        try {
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $kd_jrs = $data['auth']['kd_jrs'];
            $data['title'] = 'Data Mahasiswa Jurusan ' . $data['auth']['name_jurusan'];

            $limit = 20;
            $offset = ($page - 1) * $limit;

            $data['mahasiswa'] = $this->model('Mahasiswa_Model')->getAllMhs($limit, $offset, $kd_jrs);

            $totalPages = $this->model('Mahasiswa_Model')->getTotalPages($limit, $kd_jrs);
            $data['pagination'] = [
                'current_page' => $page,
                'total_pages' => $totalPages
            ];

            $this->view('layouts/header', $data);
            $this->view('layouts/sidebar', $data);
            $this->view('layouts/topnav', $data);
            $this->view('mahasiswa/index', $data);
            $this->view('layouts/footer', $data);
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function show($id_mhs)
    {
        $data = $this->model('Mahasiswa_Model')->getMhsById($id_mhs);
        echo json_encode($data);
    }

    public function import()
    {
        try {
            $data['auth'] = $this->model('Auth_Model')->getUserLogin();
            $kd_jrs = $data['auth']['kd_jrs'];

            $file = $_FILES['file']['tmp_name'];

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet()->toArray();

            $headerRow = $worksheet[0];
            $isHeader = is_string($headerRow[0]);

            if ($isHeader) {
                array_shift($worksheet);
            }

            $newData = array();
            $duplicateEntries = array();
            foreach ($worksheet as $row) {
                $name = $row[0];
                $nrp = $row[1];
                $email = $row[2];
                $angkatan = $row[3];
                $strata = $row[4];

                $isDuplicate = $this->model('Mahasiswa_Model')->getNrpMhsByJrs($nrp, $kd_jrs);

                if ($isDuplicate) {
                    $duplicateEntries[] = array(
                        "name" => $name,
                        "nrp" => $nrp,
                        "email" => $email,
                        "angkatan" => $angkatan,
                        "strata" => $strata
                    );
                } else {
                    $newData[] = array(
                        "name" => $name,
                        "nrp" => $nrp,
                        "email" => $email,
                        "kd_jrs" => $kd_jrs,
                        "angkatan" => $angkatan,
                        "strata" => $strata
                    );
                }
            }

            if (!empty($duplicateEntries)) {
                Flasher::setFlash('Terdapat NIM yang sama, data tidak dimasukkan', '', 'danger');
            } else {
                $this->model('Mahasiswa_Model')->importMhs($newData);
                Flasher::setFlash('Berhasil Mengimport Data ', 'Mahasiswa', 'success');
            }
            header("Location: " . BASE_URL . "Mahasiswa");
        } catch (\PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function update()
    {
        $errors = [];

        if (empty($_POST['name'])) {
            $errors['name'] = "Nama Mahasiswa Tidak Boleh Kosong.";
        }

        if (empty($_POST['nrp'])) {
            $errors['nrp'] = "NRP Mahasiswa Tidak Boleh Kosong.";
        }

        if (empty($_POST['email'])) {
            $errors['email'] = "Email Mahasiswa Tidak Boleh Kosong.";
        }

        if (empty($errors)) {
            $this->model('Mahasiswa_Model')->updateMhs($_POST);

            Flasher::setFlash('Berhasil Mengubah Data Mahasiswa', '', 'success');
            header("Location: " . BASE_URL . "Mahasiswa");
            exit;
        } else {
            Flasher::setValidation($errors);
            header("Location: " . BASE_URL . "Mahasiswa");
            exit;
        }
    }

    public function destroyMhs($id_mhs)
    {
        if ($this->model('Mahasiswa_Model')->deleteMhs($id_mhs)) {
            echo json_encode("berhasil");
        } else {
            echo json_encode("gagal");
        }
    }

    public function searchAllMhs($page = 1)
    {
        try {
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $kd_jrs = $data['auth']['kd_jrs'];
            $data['title'] = 'Data Mahasiswa Jurusan ' . $data['auth']['name_jurusan'];

            $limit = 20;
            $offset = ($page - 1) * $limit;

            $search = htmlspecialchars($_POST['search']);
            $data['mahasiswa'] = $this->model('Mahasiswa_Model')->searchAllMhs($limit, $offset, $search, $kd_jrs);

            $totalPages = $this->model('Mahasiswa_Model')->getTotalPages($limit, $kd_jrs);
            $data['pagination'] = [
                'current_page' => $page,
                'total_pages' => $totalPages
            ];

            $this->view('layouts/header', $data);
            $this->view('layouts/sidebar', $data);
            $this->view('layouts/topnav', $data);
            $this->view('mahasiswa/index', $data);
            $this->view('layouts/footer', $data);
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }
}
