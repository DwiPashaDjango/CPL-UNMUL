<?php

class Indikator_Model
{
    private $table = 'indikator';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function gatIndikator()
    {
        $this->db->query("SELECT * FROM $this->table");
        $this->db->execute();

        return $this->db->resultSet();
    }

    public function getIndikatorById($id_indikator)
    {
        $this->db->query("SELECT * FROM $this->table WHERE id_indikator = :id_indikator");
        $this->db->bind('id_indikator', $id_indikator);
        return $this->db->single();
    }

    public function insertIndikator($data)
    {
        $this->db->query("INSERT INTO $this->table (rentang_awal, rentang_akhir, bobot_huruf) VALUES (:rentang_awal, :rentang_akhir, :bobot_huruf)");
        $this->db->bind('rentang_awal', $data['rentang_awal']);
        $this->db->bind('rentang_akhir', $data['rentang_akhir']);
        $this->db->bind('bobot_huruf', $data['bobot_huruf']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateIndikator($data)
    {
        $this->db->query("UPDATE $this->table SET rentang_awal = :rentang_awal, rentang_akhir = :rentang_akhir, bobot_huruf = :bobot_huruf WHERE id_indikator = :id_indikator");
        $this->db->bind('rentang_awal', $data['rentang_awal_update']);
        $this->db->bind('rentang_akhir', $data['rentang_akhir_update']);
        $this->db->bind('bobot_huruf', $data['bobot_huruf_update']);
        $this->db->bind('id_indikator', $data['id_indikator_update']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function deleteIndikator($id_indikator)
    {
        $this->db->query("DELETE FROM $this->table WHERE id_indikator = :id_indikator");
        $this->db->bind('id_indikator', $id_indikator);
        $this->db->execute();

        return $this->db->resultSet();
    }
}
