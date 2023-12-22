<?php

use Dompdf\Dompdf;

class Matkul extends Controller
{
    public function __construct()
    {
        Middleware::auth();
    }

    public function index()
    {
        try {
            $data['title'] = 'Matrix Mata Kuliah';
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $cp_count = $data['auth']['cp_count'];
            $kd_jrs = $data['auth']['kd_jrs'];
            $data['mata_kuliah'] = $this->model('Mata_Kuliah_Model')->getAllMkByJrs($kd_jrs);

            $data['matkul'] = $this->model('Matkul_Model')->getAllCp();
            if ($cp_count > 0 && $data['matkul'] > 0) {
                $data['total_cp'] = $this->model('Matkul_Model')->sumCp($cp_count);
            }

            $this->view('layouts/header', $data);
            $this->view('layouts/sidebar', $data);
            $this->view('layouts/topnav', $data);
            $this->view('matrix/matkul/index', $data);
            $this->view('layouts/footer', $data);
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function createMatkul()
    {
        try {
            $errors = [];

            if (empty($errors)) {
                $data['auth'] = $this->model('Auth_Model')->getUserLogin();
                $cp_count = $data['auth']['cp_count'];
                $data_array = [
                    "data" => $_POST,
                    "cp_count" => $cp_count
                ];
                $this->model('Matkul_Model')->insertMatkul($data_array);

                Flasher::setFlash('Berhasil Menambahkan Mata Kuliah ', 'Baru Beserta CPny.', 'success');
                header("Location: " . BASE_URL . 'Matkul');
                exit;
            } else {
                Flasher::setValidation($errors);
                header("Location: " . BASE_URL . 'Matkul');
                exit;
            }
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function show($id_cp)
    {
        $data = $this->model('Matkul_Model')->getMatkulByIdCp($id_cp);
        echo json_encode($data);
    }

    public function update()
    {
        try {
            $data['auth'] = $this->model('Auth_Model')->getUserLogin();
            $this->model('Matkul_Model')->updateMatkul($_POST);

            Flasher::setFlash('Berhasil Mengubah ', 'Cp Di Mata Kuliah.', 'success');
            header("Location: " . BASE_URL . 'Matkul');
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function destroy($id_cp)
    {
        if ($this->model('Matkul_Model')->deleteCp($id_cp) > 0) {
            echo json_encode("Berhasil");
        } else {
            echo json_encode("Gagal");
        }
    }

    public function exportPdf()
    {
        try {
            $dompdf = new Dompdf();
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $cp_count = $data['auth']['cp_count'];

            $data['matkul'] = $this->model('Matkul_Model')->getMatkul();
            if (!empty($data['matkul'])) {
                $data['total_cp'] = $this->model('Matkul_Model')->sumCp($cp_count);
            }

            $html = '<!DOCTYPE html>
                    <html>
                        <head>
                            <style>
                                /* styles.css */
                                .table-container {
                                    max-width: 100%;
                                }

                                .custom-table {
                                    width: 100%;
                                    border-collapse: collapse;
                                    background-color: #f8f8f8;
                                    border: 1px solid #ddd;
                                }

                                .custom-table th,
                                .custom-table td {
                                    padding: 8px;
                                    text-align: left;
                                    border: 1px solid #ddd;
                                }

                                .custom-table th {
                                    background-color: #333;
                                    color: white;
                                }

                                .custom-table tbody tr:nth-child(even) {
                                    background-color: #f2f2f2;
                                }

                                .custom-table tbody tr:hover {
                                    background-color: #ddd;
                                }
                            </style>
                        </head>

                        <body>
                            <div class="table-container">
                                <table>
                                    <tr>
                                        <td>
                                            Fakultas : Pertanian <br />
                                            Jurusan  : ' . $data['auth']['name_jurusan'] . ' <br />
                                            Tahun    : ' . date('Y') . '
                                        </td>
                                    </tr>
                                </table>
                                <h2 style="text-align: center;">Matrix Mata Kuliah</h2>
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th>Kode Mata Kuliah</th>
                                            <th>Nama Mata Kuliah</th>';

            for ($i = 1; $i <= $cp_count; $i++) {
                $html .= '<th style="text-align: center;">CP' . $i . '</th>';
            }

            $html .= '</tr>
                                    </thead>
                                    <tbody>';

            foreach ($data['matkul'] as $mk) {
                $html .= '<tr>
                                            <td>' . $mk['kd_mk'] . '</td>
                                            <td>' . $mk['nm_mk'] . '</td>';
                for ($i = 1; $i <= $cp_count; $i++) {
                    if ($mk['cp_' . $i] == 1) {
                        $html .= '<td style="background-color: #f0e802; color: black; text-align: center;">' . $mk['cp_' . $i] . '</td>';
                    } else if ($mk['cp_' . $i] == 2) {
                        $html .= '<td style="background-color: #32e33b; color: white; text-align: center;">' . $mk['cp_' . $i] . '</td>';
                    } else if ($mk['cp_' . $i] == 3) {
                        $html .= '<td style="background-color: #d10f32; color: white; text-align: center;">' . $mk['cp_' . $i] . '</td>';
                    } else {
                        $html .= '<td style="text-align: center">-</td>';
                    }
                }
                $html .= '</tr>';
            }

            $html .= '</tbody>
                      <tfoot>
                      <tr>
                      <th colspan="2" style="text-align:center;">Total</th>';
            for ($i = 1; $i <=  $cp_count; $i++) {
                $html .= '<th style="text-align: center;">' . $data['total_cp']['cp_' . $i] . '</th>';
            }
            $html .= '</tr>
                       </tfoot>
                        </table>
                            </div>
                        </body>
                    </html>';

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $dompdf->stream('matrix-matkul-jurusan-' . $data['auth']['name_jurusan'] . '-' . date('Y') . '.pdf');
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function setCpCount()
    {
        $data = $this->model('Jurusan_Model')->updateCpCount($_POST);
        echo json_encode($data);
    }

    public function updateCpCount()
    {
        try {
            $errors = [];

            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $kd_jrs = $data['auth']['kd_jrs'];

            if (empty($_POST['batas_update'])) {
                $errors['batas_update'] = "Masukan Jumlah Batas Minimal Nilai Capaian.";
            }

            if (empty($_POST['cp_count_update'])) {
                $errors['cp_count_update'] = "Masukan Jumlah Capaian Juruan Jurusan.";
            }

            if (empty($errors)) {
                $datas = [
                    "batas" => $_POST['batas_update'],
                    "cp_count" => $_POST['cp_count_update'],
                    "kd_jrs" => $kd_jrs
                ];
                $this->model('Jurusan_Model')->updateCpCount($datas);

                Flasher::setFlash('Berhasil Mengubah ', 'Jumlah Capaian Dan Batas Minimal.', 'success');
                header("Location: " . BASE_URL . 'Matkul');
                exit;
            } else {
                Flasher::setValidation($errors);
                header("Location: " . BASE_URL . 'Matkul');
                exit;
            }
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }
}
