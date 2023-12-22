<?php

use Dompdf\Dompdf;

class Penilaian_CPL extends Controller
{
    public function __construct()
    {
        Middleware::auth();
    }

    public function index()
    {
        try {
            $data['title'] = 'Matrix Penilaian CP Lulusan';
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $kd_jrs = $data['auth']['kd_jrs'];
            $cp_count = $data['auth']['cp_count'];

            $data['indikator'] = $this->model('Indikator_Model')->gatIndikator();
            $data['mhs'] = $this->model('Mahasiswa_Model')->getMhsByJrs($kd_jrs);
            if ($cp_count > 0) {
                $data['matkul'] = $this->model('Matkul_Model')->getMatkul();
                $data['total_cp'] = $this->model('Matkul_Model')->sumCp($cp_count);
                $data['nilai'] = $this->model('Nilai_Model')->getNilaiMhsJrs($kd_jrs);
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
            $this->view('matrix/penilaian_cpl/index', $data);
            $this->view('layouts/footer', $data);
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function saveNialiCpMhs($id_mhs)
    {
        try {
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $cp_count = $data['auth']['cp_count'];
            $data['mhs'] = $this->model('Mahasiswa_Model')->getMhsByNrp($id_mhs);

            $data['nilai'] = $this->model('Nilai_Model')->getNilaiRelation($id_mhs);
            $data['matkul'] = $this->model('Matkul_Model')->getMatkul();
            if (!empty($data['matkul'])) {
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

            $column_totals = array_fill(0, $data['auth']['cp_count'], 0);
            foreach ($data['matkul'] as $mk) {
                for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
                    if ($mk['cp_' . $i] != null) {
                        $bobot_cp = ($mk['sks'] * $mk['cp_' . $i]);
                        $persen2 = ($bobot_cp / $data['total_bobot_percp']['cp_' . $i]) * 100;
                        foreach ($data['nilai'] as $nk) {
                            if ($nk['kd_mk'] == $mk['kd_mk']) {
                                $nilai_mhs = $nk['bobot'];
                                $result = ($persen2 * $nilai_mhs) / 100;
                                $column_totals[$i - 1] += $result;
                            }
                        }
                    }
                }
            }
            $total_data = [];
            foreach ($column_totals as $i => $total) {
                $total_data["total_cp"] = $data['auth']['cp_count'];
                $total_data["batas"] = $data['auth']['batas'];
                $total_data["mhs_id"] = $data['mhs']['id_mhs'];
                $total_data["cp_" . ($i + 1)] = number_format($total, 2);
            }

            $this->model('Save_CP_Mhs_Model')->insert($total_data);
            Flasher::setFlash('Berhasil Menyimpan Data Nilai CPL ', 'Dan Meluluskan Mahasiswa', 'success');
            header("Location: " . BASE_URL . "Penilaian_CPL");
            exit;
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function show($id_mhs)
    {
        try {
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $data['mhs'] = $this->model('Mahasiswa_Model')->getMhsByNrp($id_mhs);
            $data['title'] = $data['mhs']['name'];
            $cp_count = $data['auth']['cp_count'];

            $data['indikator'] = $this->model('Indikator_Model')->gatIndikator();
            $data['nilai'] = $this->model('Nilai_Model')->getNilaiRelation($id_mhs);
            $data['matkul'] = $this->model('Matkul_Model')->getMatkul();
            if (!empty($data['matkul'])) {
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
            $this->view('matrix/penilaian_cpl/show', $data);
            $this->view('layouts/footer', $data);
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function geneteratePdfAll()
    {
        try {
            $dompdf = new Dompdf();
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $kd_jrs = $data['auth']['kd_jrs'];
            $cp_count = $data['auth']['cp_count'];

            $data['mhs'] = $this->model('Mahasiswa_Model')->getMhsByJrs($kd_jrs);
            $data['matkul'] = $this->model('Matkul_Model')->getMatkul();
            if ($cp_count > 0) {
                $data['total_cp'] = $this->model('Matkul_Model')->sumCp($cp_count);
            }
            $data['indikator'] = $this->model('Indikator_Model')->gatIndikator();
            $data['nilai'] = $this->model('Nilai_Model')->getNilaiMhsJrs($kd_jrs);

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

            $html = '<!DOCTYPE html>
                    <html>
                        <head>
                            <style>
                            #customers {
                                font-family: Arial, Helvetica, sans-serif;
                                border-collapse: collapse;
                                width: 100%;
                            }

                            #customers td, #customers th {
                                border: 1px solid #ddd;
                                padding: 8px;
                            }

                            #customers tr:nth-child(even){background-color: #f2f2f2;}

                            #customers tr:hover {background-color: #ddd;}

                            #customers th {
                                padding-top: 12px;
                                padding-bottom: 12px;
                                text-align: left;
                                background-color: gray;
                            }
                            </style>
                        </head>
                    <body>
                        <table>
                            <tr>
                                <td>
                                    Fakultas : Pertanian <br />
                                    Jurusan  : ' . $data['auth']['name_jurusan'] . ' <br />
                                    Tahun    : ' . date('Y') . '
                                </td>
                            </tr>
                        </table>
                        <h2 style="text-align: center;">Matrix Penilaian CP Lulusan</h2>
                        <table id="customers">
                            <tr>
                                <th>Nama Mahasiswa</th>';
            for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
                $html .= '<th style="text-align: center;">CP' . $i . '</th>';
            }
            $html .= '</tr>';
            foreach ($data['mhs'] as $mhs) {
                $html .= '<tr>';
                $html .= '<td>' . $mhs['name'] . '</td>';
                $column_totals = array_fill(0, $data['auth']['cp_count'], 0);
                foreach ($data['matkul'] as $mk) {
                    for ($i = 1; $i <= $data['auth']['cp_count']; $i++) {
                        $bobot_cp = ($mk['sks'] * $mk['cp_' . $i]);
                        $persen = ($bobot_cp / $data['total_bobot_percp']['cp_' . $i]) * 100;
                        foreach ($data['nilai'] as $nk) {
                            if ($nk['mhs_id'] == $mhs['id_mhs']) {
                                if ($nk['kd_mk'] == $mk['kd_mk']) {
                                    $nilai_mhs = $nk['bobot'];
                                    $result = ($persen * $nilai_mhs) / 100;
                                    $column_totals[$i - 1] += number_format($result, 2);
                                }
                            }
                        }
                    }
                }
                foreach ($column_totals as $total) {
                    $html .= '<td style="text-align: center;">' . $total . '%</td>';
                }
                $html .= '</tr>';
            }
            $html .= '</table>
                    </body>
                </html>';

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $dompdf->stream('matrix-penilaian-CPL-jurusan-' . $data['auth']['name_jurusan'] . '-' . date('Y') . '.pdf');
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function generatePdfCpMhs($id_mhs)
    {
        try {
            $dompdf = new Dompdf();

            $data['auth'] = $this->model('Auth_Model')->getUserLogin();
            $data['mhs'] = $this->model('Mahasiswa_Model')->getMhsByNrp($id_mhs);
            $data['title'] = $data['mhs']['name'];
            $cp_count = $data['auth']['cp_count'];

            $data['nilai'] = $this->model('Nilai_Model')->getNilaiRelation($id_mhs);
            $data['matkul'] = $this->model('Matkul_Model')->getMatkul();
            if (!empty($data['matkul'])) {
                $data['total_cp'] = $this->model('Matkul_Model')->sumCp($cp_count);
            }

            $html = $this->loadView('pdf/pdf_penilaian', $data);
            $dompdf->loadHtml($html);

            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            ob_clean();

            $fileName = $data['title'];
            header('Content-Disposition: attachment;filename="document.pdf"');

            header('Content-Type: application/pdf');

            $dompdf->stream($fileName . '.pdf');
            exit();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    private function loadView($view, $data)
    {
        ob_start();
        extract($data);
        $this->view($view, $data);
        return ob_get_clean();
    }
}
