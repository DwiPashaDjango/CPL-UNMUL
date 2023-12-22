<?php

class Evaluasi extends Controller
{
    public function __construct()
    {
        Middleware::auth();
    }

    public function index()
    {
        try {
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $kd_jrs = $data['auth']['kd_jrs'];
            $data['title'] = 'Evaluasi Penilaian CP Lulusan';
            $cp_count = $data['auth']['cp_count'];

            $data['indikator'] = $this->model('Indikator_Model')->gatIndikator();
            $data['mhs'] = $this->model('Mahasiswa_Model')->getMhsByJrsEvaluasi($kd_jrs);

            $this->view('layouts/header', $data);
            $this->view('layouts/sidebar', $data);
            $this->view('layouts/topnav', $data);
            $this->view('evaluasi/index', $data);
            $this->view('layouts/footer', $data);
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function GenerateEvaluasi()
    {
        try {
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $data['title'] = 'Report';
            $errors = [];

            if (empty($_POST['id_mhs'])) {
                $errors['id_mhs'] = "Pilih Mahasiswa Yang Akan Di Evaluasi";
            }

            if (empty($errors)) {
                $datas = [
                    "cp_count" => $data['auth']['cp_count'],
                    "id_mhs" => $_POST['id_mhs']
                ];
                $data['mhs'] = $this->model('Evaluasi_Model')->getMhsInId($datas);
                $data['matkul'] = $this->model('Matkul_Model')->getMatkul();
                $data['nilai'] = $this->model('Nilai_Model')->getNilaiMhsJrs($data['auth']['kd_jrs']);

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
                $this->view('evaluasi/show', $data);
                $this->view('layouts/footer', $data);
            } else {
                Flasher::setValidation($errors);
                header("Location: " . BASE_URL . "Evaluasi");
            }
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }
}
