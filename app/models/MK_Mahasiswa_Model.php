<?php

class MK_Mahasiswa_Model
{
    private $table = 'mahasiswa_matakuliah';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllMhsMk()
    {
        $kd_jrs = $_SESSION['kd_jrs'];
        $this->db->query(
            "SELECT DISTINCT mata_kuliah.*, matkul.*, mahasiswa.id_mhs, mahasiswa.kd_jrs
            FROM $this->table
            INNER JOIN mata_kuliah ON mata_kuliah.kd_mk = $this->table.kd_mk
            INNER JOIN matkul ON matkul.kd_mk = $this->table.kd_mk
            INNER JOIN mahasiswa ON mahasiswa.id_mhs = $this->table.mhs_id
            WHERE mahasiswa.kd_jrs = :kd_jrs
            GROUP BY mata_kuliah.id_mk, matkul.id_cp, mahasiswa.id_mhs"
        );
        $this->db->bind('kd_jrs', $kd_jrs);
        return $this->db->resultSet();
    }

    public function getMkByMhs($id_mhs)
    {
        $kd_jrs = $_SESSION['kd_jrs'];
        $this->db->query(
            "SELECT DISTINCT mata_kuliah.*, matkul.*
            FROM $this->table
            INNER JOIN mata_kuliah ON mata_kuliah.kd_mk = $this->table.kd_mk
            INNER JOIN matkul ON matkul.kd_mk = $this->table.kd_mk
            WHERE $this->table.mhs_id = :mhs_id AND mata_kuliah.kd_jrs = :kd_jrs"
        );
        $this->db->bind('mhs_id', $id_mhs);
        $this->db->bind('kd_jrs', $kd_jrs);
        return $this->db->resultSet();
    }

    public function saveMkMhs($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $this->db->query("INSERT INTO $this->table (kd_mk, mhs_id) VALUES (:kd_mk, :mhs_id)");
            $this->db->bind('kd_mk', $data[$i]['kd_mk']);
            $this->db->bind('mhs_id', $data[$i]['mhs_id']);
            $this->db->execute();
        }
        return $this->db->rowCount();
    }
}
