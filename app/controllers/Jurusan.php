<?php

use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Base;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Jurusan extends Controller
{
    public function __construct()
    {
        Middleware::auth();
    }

    public function index()
    {
        try {
            $data['title'] = 'Data Jurusan';
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();

            $data['jurusan'] = $this->model('Jurusan_Model')->getAllJurusan();

            $this->view('layouts/header', $data);
            $this->view('layouts/sidebar', $data);
            $this->view('layouts/topnav', $data);
            $this->view('jurusan/index', $data);
            $this->view('layouts/footer', $data);
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function import()
    {
        try {
            $file = $_FILES['file']['tmp_name'];

            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet()->toArray();

            $data = array();
            for ($row = 1; $row < count($worksheet); $row++) {
                $kd_jrs = $worksheet[$row][0];
                $name_jurusan = $worksheet[$row][1];

                $data[] = array(
                    "kd_jrs" => $kd_jrs,
                    "name_jurusan" => $name_jurusan,
                );
            }
            $this->model('Jurusan_Model')->importJrs($data);
            Flasher::setFlash('Berhasil Mengimport Data ', ' Jurusan', 'success');
            header("Location: " . BASE_URL . "Jurusan");
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function show($kd_jrs)
    {
        $data = $this->model('Jurusan_Model')->getJurusan($kd_jrs);
        echo json_encode($data);
    }

    public function update()
    {
        $errors = [];

        if (empty($_POST['name_jurusan'])) {
            $errors['name_jurusan'] = 'Silahkan Isi Nama Jurusan';
        }

        if (empty($errors)) {
            $this->model('Jurusan_Model')->updateJurusan($_POST);
            Flasher::setFlash('Berhasil Mengubah Data ', ' Jurusan', 'success');
            header("Location: " . BASE_URL . "Jurusan");
            exit;
        } else {
            Flasher::setValidation($errors);
            header("Location: " . BASE_URL . "Jurusan");
            exit;
        }
    }

    public function destroy($id_jrs)
    {
        if ($this->model('Jurusan_Model')->deleteJrs($id_jrs) > 0) {
            echo json_encode("Berhasil");
        } else {
            echo json_encode("Gagal");
        }
    }

    public function addCP()
    {
        try {
            $data = [
                "kd_jrs" => $_POST['kd_jrs_cp'],
                "cp_count" => $_POST['cp_count'],
                "batas" => $_POST['batas']
            ];

            $this->model('Jurusan_Model')->updateCpCount($data);
            Flasher::setFlash('Berhasil Menambahkan Jumlah CP Ke Jurusan', '', 'success');
            header("Location: " . BASE_URL . "Jurusan");
            exit;
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function addJurusanOne()
    {
        try {
            $errors = [];

            $name_jurusan = $_POST['name_jurusan'];

            if (empty($name_jurusan)) {
                $errors['name_jurusan'] = 'Silahkan Isi Nama Jurusan';
            }

            if (empty($errors)) {
                $hAwal = substr($name_jurusan, 0, 1);
                $hAkhir = substr($name_jurusan, -1);
                $resultText = strtoupper($hAwal . $hAkhir);

                $datas = [
                    "kd_jurusan" => $resultText,
                    "name_jurusan" => $name_jurusan,
                ];

                $this->model('Jurusan_Model')->addJurusan($datas);
                Flasher::setFlash('Berhasil Menambahkan Data Jurusan Baru.', '', 'success');
                header("Location: " . BASE_URL . "Jurusan");
                exit;
            } else {
                Flasher::setValidation($errors);
                header("Location: " . BASE_URL . "Jurusan");
                exit;
            }
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }
}
