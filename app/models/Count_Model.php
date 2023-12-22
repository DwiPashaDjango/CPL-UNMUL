<?php

class Count_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function countMhsActive($kd_jrs)
    {
        $this->db->query("SELECT COUNT(*) as total FROM mahasiswa WHERE status = :status AND kd_jrs = :kd_jrs");
        $this->db->bind('status', 0);
        $this->db->bind('kd_jrs', $kd_jrs);
        $this->db->execute();

        return $this->db->resultSet();
    }

    public function countLulusan($kd_jrs)
    {
        $this->db->query("SELECT COUNT(*) as total FROM mahasiswa WHERE status = :status AND kd_jrs = :kd_jrs");
        $this->db->bind('status', 1);
        $this->db->bind('kd_jrs', $kd_jrs);
        $this->db->execute();

        return $this->db->resultSet();
    }

    public function countMkByKdJrs($kd_jrs)
    {
        $this->db->query("SELECT COUNT(*) as total FROM mata_kuliah WHERE kd_jrs = :kd_jrs");
        $this->db->bind('kd_jrs', $kd_jrs);
        $this->db->execute();

        return $this->db->resultSet();
    }
}
