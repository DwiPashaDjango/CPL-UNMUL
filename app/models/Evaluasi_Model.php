<?php

class Evaluasi_Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getMhsInId($data)
    {
        $placeholders = implode(',', $data['id_mhs']);
        $sql = "SELECT * FROM mahasiswa WHERE id_mhs IN ($placeholders)";
        $this->db->query($sql);
        $this->db->execute();

        return $this->db->resultSet();
    }
}
