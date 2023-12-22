<?php

class Dashboard extends Controller
{
    public function __construct()
    {
        Middleware::auth();
    }

    public function index()
    {
        try {
            $data['title'] = 'Dashboard';
            $data['auth']  = $this->model('Auth_Model')->getUserLogin();
            $kd_jrs = $data['auth']['kd_jrs'];

            $data['mhs_active_count'] = $this->model('Count_Model')->countMhsActive($kd_jrs);
            $data['mhs_lulus_count']  = $this->model('Count_Model')->countLulusan($kd_jrs);
            $data['count_mk_by_jrs']  = $this->model('Count_Model')->countMkByKdJrs($kd_jrs);
            $data['chart_json'] = $this->model('Mahasiswa_Model')->countMhsByAngkatan($kd_jrs);

            $this->view('layouts/header', $data);
            $this->view('layouts/sidebar', $data);
            $this->view('layouts/topnav', $data);
            $this->view('dashboard', $data);
            $this->view('layouts/footer', $data);
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }
}
