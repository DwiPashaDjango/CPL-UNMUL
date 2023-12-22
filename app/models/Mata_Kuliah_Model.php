<?php

class Mata_Kuliah_Model
{
    private $table = 'mata_kuliah';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllMkByJrs($kd_jrs)
    {
        $this->db->query("SELECT $this->table.*, jurusan.kd_jrs, jurusan.name_jurusan
                          FROM $this->table 
                          INNER JOIN jurusan ON jurusan.kd_jrs = $this->table.kd_jrs
                          WHERE $this->table.kd_jrs = :kd_jrs AND $this->table.deleted_at IS NULL
                          ORDER BY id_mk DESC
                        ");
        $this->db->bind('kd_jrs', $kd_jrs);
        return $this->db->resultSet();
    }

    public function getMkByKd($kd_mk)
    {
        $this->db->query("SELECT * FROM $this->table WHERE kd_mk = :kd_mk");
        $this->db->bind('kd_mk', $kd_mk);
        return $this->db->single();
    }

    public function importMk($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['kd_mk'] != NULL && $data[$i]['nm_mk'] != NULL && $data[$i]['sks'] != NULL) {
                $this->db->query("INSERT INTO $this->table (kd_mk, kd_jrs, nm_mk, sks) VALUES (:kd_mk, :kd_jrs, :nm_mk, :sks)");
                $this->db->bind('kd_mk', $data[$i]['kd_mk']);
                $this->db->bind('kd_jrs', $data[$i]['kd_jrs']);
                $this->db->bind('nm_mk', $data[$i]['nm_mk']);
                $this->db->bind('sks', $data[$i]['sks']);
                $this->db->execute();
            }
        }
        return $this->db->rowCount();
    }

    public function insertOneMk($data)
    {
        $this->db->query("INSERT INTO $this->table (kd_mk, nm_mk, sks, kd_jrs) VALUES (:kd_mk, :nm_mk, :sks, :kd_jrs)");
        $this->db->bind('kd_mk', $data['kd_mk']);
        $this->db->bind('nm_mk', $data['nm_mk']);
        $this->db->bind('sks', $data['sks']);
        $this->db->bind('kd_jrs', $data['kd_jrs']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateMk($data)
    {
        $this->db->query("UPDATE $this->table SET nm_mk = :nm_mk, sks = :sks WHERE kd_mk = :kd_mk");
        $this->db->bind('nm_mk', $data['nm_mk']);
        $this->db->bind('sks', $data['sks']);
        $this->db->bind('kd_mk', $data['kd_mk']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function deleteMkAndCP($id_mk)
    {
        $this->db->query("UPDATE $this->table SET deleted_at = :deleted_at WHERE id_mk = :id_mk");
        $this->db->bind('deleted_at', date('Y-m-d H:i:s'));
        $this->db->bind('id_mk', $id_mk);
        $this->db->execute();
        return $this->db->resultSet();
    }
}
