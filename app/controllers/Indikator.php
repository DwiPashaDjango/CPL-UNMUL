<?php

class Indikator extends Controller
{
    public function __construct()
    {
        Middleware::auth();
    }

    public function index()
    {
        try {
            $data['title'] = 'Data Indikator Nilai';
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $data['indikator'] = $this->model('Indikator_Model')->gatIndikator();
            // var_dump($data['indikator']);
            // die;

            $this->view('layouts/header', $data);
            $this->view('layouts/sidebar', $data);
            $this->view('layouts/topnav', $data);
            $this->view('indikator/index', $data);
            $this->view('layouts/footer', $data);
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function show($id_indikator)
    {
        $data = $this->model('Indikator_Model')->getIndikatorById($id_indikator);
        echo json_encode($data);
    }

    public function store()
    {
        $errors = [];

        if (!isset($_POST['rentang_awal']) || $_POST['rentang_awal'] === '') {
            $errors['rentang_awal'] = "Masukan Nilai Rentang Awal";
        }

        if (!isset($_POST['rentang_akhir']) || $_POST['rentang_akhir'] === '') {
            $errors['rentang_akhir'] = "Masukan Nilai Rentang Akhir";
        }

        if (!isset($_POST['bobot_huruf']) || $_POST['bobot_huruf'] === '') {
            $errors['bobot_huruf'] = "Masukan Nilai Huruf";
        }

        if (empty($errors)) {
            $this->model('Indikator_Model')->insertIndikator($_POST);
            Flasher::setFlash('Berhasil Menambahkan Nilai ', 'Indikator', 'success');
            header("Location: " . BASE_URL . "Indikator");
            exit;
        } else {
            Flasher::setValidation($errors);
            header("Location: " . BASE_URL . "Indikator");
            exit;
        }
    }

    public function update()
    {
        $errors = [];

        if (!isset($_POST['rentang_awal_update']) || $_POST['rentang_awal_update'] === '') {
            $errors['rentang_awal_update'] = "Masukan Nilai Rentang Awal";
        }

        if (!isset($_POST['rentang_akhir_update']) || $_POST['rentang_akhir_update'] === '') {
            $errors['rentang_akhir_update'] = "Masukan Nilai Rentang Akhir";
        }

        if (!isset($_POST['bobot_huruf_update']) || $_POST['bobot_huruf_update'] === '') {
            $errors['bobot_huruf_update'] = "Masukan Nilai Huruf";
        }

        if (empty($errors)) {
            $this->model('Indikator_Model')->updateIndikator($_POST);
            Flasher::setFlash('Berhasil Mengubah Nilai ', 'Indikator', 'success');
            header("Location: " . BASE_URL . "Indikator");
            exit;
        } else {
            Flasher::setValidation($errors);
            header("Location: " . BASE_URL . "Indikator");
            exit;
        }
    }

    public function destroy($id_indikator)
    {
        if ($this->model('Indikator_Model')->deleteIndikator($id_indikator) > 0) {
            echo json_encode("Berhasil");
        } else {
            echo json_encode("Gagal");
        }
    }
}
