<?php

use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Base;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Nilai extends Controller
{
    public function __construct()
    {
        Middleware::auth();
    }

    public function index()
    {
        try {
            $data['title'] = 'Data Nilai Mahasiswa';
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $kd_jrs = $data['auth']['kd_jrs'];

            $data['mahasiswa'] = $this->model('Mahasiswa_Model')->getMhsByJrs($kd_jrs);
            // var_dump($data['auth']);
            // die;

            $this->view('layouts/header', $data);
            $this->view('layouts/sidebar', $data);
            $this->view('layouts/topnav', $data);
            $this->view('nilai/index', $data);
            $this->view('layouts/footer', $data);
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }


    public function show($id_mhs)
    {
        try {
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $kd_jrs = $data['auth']['kd_jrs'];
            $cp_count = $data['auth']['cp_count'];

            $data['mhs'] = $this->model('Mahasiswa_Model')->getMhsByNrp($id_mhs);
            $data['title'] = $data['mhs']['name'];
            $data['all_mk'] = $this->model('Mata_Kuliah_Model')->getAllMkByJrs($kd_jrs);

            $data['nilai'] = $this->model('Nilai_Model')->getNilaiRelation($id_mhs);
            $data['matkul'] = $this->model('MK_Mahasiswa_Model')->getMkByMhs($id_mhs);
            $data['indikator'] = $this->model('Indikator_Model')->gatIndikator();
            if ($cp_count > 0) {
                $data['total_cp'] = $this->model('Matkul_Model')->sumCp($cp_count);
            }

            $total_per_cp = array_fill(1, $data['auth']['cp_count'], 0);
            $total_cp_arr = [];
            for ($row = 1; $row <= $data['auth']['cp_count']; $row++) {
                $total_cp_arr["cp_$row"] = 0;
            }

            foreach ($data['matkul'] as $mk) {
                for ($row = 1; $row <= $data['auth']['cp_count']; $row++) {
                    if ($mk['cp_' . $row] != null) {
                        $persen = ($mk['sks'] * $mk['cp_' . $row]);
                        $total_cp_arr["cp_$row"] += $persen;
                        $total_per_cp[$row] += $persen;
                    }
                }
            }
            $data['total_bobot_percp'] = $total_cp_arr;

            $this->view('layouts/header', $data);
            $this->view('layouts/sidebar', $data);
            $this->view('layouts/topnav', $data);
            $this->view('nilai/show', $data);
            $this->view('layouts/footer', $data);
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function edit($id_nilai)
    {
        $data = $this->model('Nilai_Model')->getNilaiById($id_nilai);
        echo json_encode($data);
    }

    public function store()
    {
        try {
            $file = $_FILES['file']['tmp_name'];

            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet()->toArray();

            $data = array();
            for ($row = 1; $row < count($worksheet); $row++) {
                $kd_mk = $worksheet[$row][0];
                $nm_mk = $worksheet[$row][1];
                $bobot = $worksheet[$row][2];
                $mhs_id = $_POST['mhs_id'];

                $data[] = array(
                    "kd_mk" => $kd_mk,
                    "nm_mk" => $nm_mk,
                    "bobot" => $bobot,
                    "mhs_id" => $mhs_id
                );
            }

            $this->model('Nilai_Model')->createNilai($data);

            Flasher::setFlash('Berhasil Mengimport Data ', 'Nilai Mahasiswa', 'success');
            header("Location: " . BASE_URL . "Nilai/show/" . $_POST['mhs_id']);
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function storeOne()
    {
        try {
            $errors = [];
            if (empty($_POST['kd_mk'])) {
                $errors['kd_mk'] = "Pilih Mata Kuliah.";
            }

            if (empty($_POST['bobot'])) {
                $errors['bobot'] = "Masukan Nilai Angka.";
            }

            if (empty($errors)) {
                $this->model('Nilai_Model')->storeNilai($_POST);
                Flasher::setFlash('Berhasil Menambahkan Data ', 'Nilai Mahasiswa', 'success');
                header("Location: " . BASE_URL . 'Nilai/show/' . $_POST['mhs_id']);
                exit;
            } else {
                Flasher::setValidation($errors);
                header("Location: " . BASE_URL . 'Nilai/show/' . $_POST['mhs_id']);
                exit;
            }
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function update()
    {
        try {
            $errors = [];
            if (empty($_POST['bobot_update'])) {
                $errors['bobot_update'] = "Masukan Nilai Angka.";
            }

            if (empty($errors)) {
                $this->model('Nilai_Model')->updateNilai($_POST);
                Flasher::setFlash('Berhasil Mengubah Data ', 'Nilai Mahasiswa', 'success');
                header("Location: " . BASE_URL . 'Nilai/show/' . $_POST['mhs_id']);
                exit;
            } else {
                Flasher::setValidation($errors);
                header("Location: " . BASE_URL . 'Nilai/show/' . $_POST['mhs_id']);
                exit;
            }
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function destroy($id_nilai)
    {
        if ($this->model('Nilai_Model')->deleteNilai($id_nilai) > 0) {
            echo json_encode("Berhasil");
        } else {
            echo json_encode("Gagal");
        }
    }

    public function filterByAngkatan()
    {
        try {
            $data['title'] = 'Data Nilai Mahasiswa';
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $year = $_POST['year'];
            $kd_jrs = $data['auth']['kd_jrs'];

            $data_array = [];
            foreach ($_POST['year'] as $years) {
                $data_array[] = [
                    "angkatan" => $years,
                    "kd_jrs" => $kd_jrs,
                    "params" => $_REQUEST
                ];
            }
            $data['mahasiswa'] = $this->model('Mahasiswa_Model')->filterMhs($data_array);

            $this->view('layouts/header', $data);
            $this->view('layouts/sidebar', $data);
            $this->view('layouts/topnav', $data);
            $this->view('nilai/index', $data);
            $this->view('layouts/footer', $data);
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function saveMk()
    {
        try {
            $errors = [];

            if (empty($_POST['kd_mk'])) {
                $errors['kd_mk'] = "Pilih Mata Kuliah Yang Di Ambil Oleh Mahasiswa";
            }

            if (empty($errors)) {
                if (is_array($_POST['kd_mk'])) {
                    $items = $_POST['kd_mk'];

                    $data = [];
                    foreach ($items as $mk) {
                        $data[] = [
                            "mhs_id" => $_POST['mhs_id'],
                            "kd_mk" => $mk
                        ];
                    }
                    $this->model('MK_Mahasiswa_Model')->saveMkMhs($data);
                    Flasher::flash('Berhasil Menyimpan Data Mata Kuliah ', 'Yang Di Pilih Oleh Mahasiswa.', 'success');
                    header("Location: " . BASE_URL . "Nilai/show/" . $_POST['mhs_id']);
                    exit;
                }
            } else {
                Flasher::setValidation($errors);
                header("Location: " . BASE_URL . "Nilai/show/" . $_POST['mhs_id']);
                exit;
            }
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    function getMkByKode($kd_mk)
    {
        $data = $this->model('Mata_Kuliah_Model')->getMkByKd($kd_mk);
        echo json_encode($data);
    }
}
