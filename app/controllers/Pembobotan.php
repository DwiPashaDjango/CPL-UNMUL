<?php

use Dompdf\Dompdf;

class Pembobotan extends Controller
{
    public function __construct()
    {
        Middleware::auth();
    }

    public function index()
    {
        try {
            $data['title'] = 'Matrix Pembobotan Mata Kuliah';
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $cp_count = $data['auth']['cp_count'];

            $data['matkul'] = $this->model('Matkul_Model')->getAllCp();
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

            // var_dump($data['total_bobot_percp']);
            // die;

            $this->view('layouts/header', $data);
            $this->view('layouts/sidebar', $data);
            $this->view('layouts/topnav', $data);
            $this->view('matrix/pembobotan/index', $data);
            $this->view('layouts/footer', $data);
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function contoh()
    {
        try {
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $cp_count = $data['auth']['cp_count'];

            $data['matkul'] = $this->model('Matkul_Model')->getAllCp();

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
            $this->view('matrix/pembobotan/contoh', $data);
            $this->view('layouts/footer', $data);
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function exportPdf()
    {
        try {
            $dompdf = new Dompdf();
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $cp_count = $data['auth']['cp_count'];

            $data['matkul'] = $this->model('Matkul_Model')->getAllCp();
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
                                    <h2 style="text-align: center;">Matrix Pembobotan Mata Kuliah</h2>
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">No</th>
                                                <th>Kode Mata Kuliah</th>
                                                <th>Nama Mata Kuliah</th>
                                                <th style="text-align: center;">SKS</th>';
            for ($i = 1; $i <= $cp_count; $i++) {
                $html .= '<th style="text-align: center;">CP' . $i . '</th>';
            }

            $html .= '</tr>
                                    </thead>
                                    <tbody>';
            $total_cp = array_fill(1, $data['auth']['cp_count'], 0);
            foreach ($data['matkul'] as $mk) {
                for ($row = 1; $row <= $data['auth']['cp_count']; $row++) {
                    if ($mk['cp_' . $row] != null) {
                        $persen = ($mk['sks'] * $mk['cp_' . $row]);
                        $total_cp[$row] += $persen;
                    }
                }
            }
            $no = 1;
            foreach ($data['matkul'] as $mk) {
                $html .= '<tr>
                                            <td style="text-align: center;">' . $no++ . '</td>
                                            <td>' . $mk['kd_mk'] . '</td>
                                            <td>' . $mk['nm_mk'] . '</td>
                                            <td style="text-align: center;">' . $mk['sks'] . '</td>';
                for ($i = 1; $i <= $cp_count; $i++) {
                    if ($mk['cp_' . $i] != null) {
                        $persen = ($mk['sks'] * $mk['cp_' . $i]);
                        $total_per_cp[$i] += $persen;

                        $html .= '<td style="text-align: center;">' . number_format(($persen / $data['total_bobot_percp']['cp_' . $i]) * 100, 2) . '%</td>';
                    } else {
                        $html .= '<td style="text-align: center">0.00%</td>';
                    }
                }
                $html .= '</tr>';
            }

            $html .= '</tbody>
                      <tfoot>
                      <tr>
                      <th colspan="4" style="text-align:center;">Total</th>';
            for ($i = 1; $i <=  $cp_count; $i++) {
                if ($data['total_cp']['cp_' . $i] != null) {
                    $html .= '<th style="text-align: center;">' . number_format(($total_cp[$i] / $data['total_bobot_percp']['cp_' . $i]) * 100, 2) . '%</th>';
                } else {
                    $html .= '<th style="text-align: center;">0.00%</th>';
                }
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
            $dompdf->stream('matrix-pembobotan-matkul-jurusan-' . $data['auth']['name_jurusan'] . '-' . date('Y') . '.pdf');
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }
}
