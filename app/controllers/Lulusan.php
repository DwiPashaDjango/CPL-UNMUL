<?php

use Dompdf\Dompdf;
use Dompdf\Options;

class Lulusan extends Controller
{
    public function __construct()
    {
        Middleware::auth();
    }

    public function index()
    {
        try {
            $data['title'] = 'Data Mahasiswa Lulus';
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $kd_jrs = $data['auth']['kd_jrs'];
            $data['mahasiswa'] = $this->model('Mahasiswa_Model')->getMhsByLulus($kd_jrs);
            // var_dump($data['auth']);
            // die;

            $this->view('layouts/header', $data);
            $this->view('layouts/sidebar', $data);
            $this->view('layouts/topnav', $data);
            $this->view('lulusan/index', $data);
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
            $data['mhs'] = $this->model('Mahasiswa_Model')->getMhsByNrp($id_mhs);
            $data['title'] = $data['mhs']['name'];
            $mhs_id = $data['mhs']['id_mhs'];

            $data['indikator'] = $this->model('Indikator_Model')->gatIndikator();
            $data['cp_mhs'] = $this->model('Save_CP_Mhs_Model')->getMhsCpLulus($mhs_id);

            $this->view('layouts/header', $data);
            $this->view('layouts/sidebar', $data);
            $this->view('layouts/topnav', $data);
            $this->view('lulusan/show', $data);
            $this->view('layouts/footer', $data);
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function generatePdf($id_mhs)
    {
        try {
            $dompdf = new Dompdf();

            $data['auth'] = $this->model('Auth_Model')->getUserLogin();

            $data['mhs'] = $this->model('Mahasiswa_Model')->getMhsByNrp($id_mhs);
            $data['title'] = $data['mhs']['name'];
            $mhs_id = $data['mhs']['id_mhs'];

            $data['cp_mhs'] = $this->model('Save_CP_Mhs_Model')->getMhsCpLulus($mhs_id);

            $html = $this->loadView('pdf/pdf_lulusan', $data);
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
