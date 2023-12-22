<?php

class Save_CP_Mhs_Model
{
    private $table = 'mhs_cp';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function insert($data)
    {
        $this->db->query(
            "INSERT INTO $this->table 
             (mhs_id, cp_1, cp_2, cp_3, cp_4, cp_5, cp_6, cp_7, cp_8, cp_9, cp_10, cp_11, cp_12, cp_13, cp_14, cp_15, cp_16, cp_17, cp_18, cp_19, cp_20, batas, total_cp)
             VALUES (:mhs_id, :cp_1, :cp_2, :cp_3, :cp_4, :cp_5, :cp_6, :cp_7, :cp_8, :cp_9, :cp_10, :cp_11, :cp_12, :cp_13, :cp_14, :cp_15, :cp_16, :cp_17, :cp_18, :cp_19, :cp_20, :batas, :total_cp)"
        );
        $this->db->bind('mhs_id', $data['mhs_id']);
        for ($i = 1; $i <= 20; $i++) {
            $cp_key = 'cp_' . $i;
            $cp_value = $data[$cp_key];
            if ($cp_value == '') {
                $cp_value = null;
            }
            $this->db->bind('cp_' . $i, $cp_value);
        }
        $this->db->bind('batas', $data['batas']);
        $this->db->bind('total_cp', $data['total_cp']);
        $this->db->execute();

        $this->db->query("UPDATE mahasiswa SET status = :status WHERE id_mhs = :mhs_id");
        $this->db->bind('status', 1);
        $this->db->bind('mhs_id', $data['mhs_id']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function getMhsCpLulus($mhs_id)
    {
        $this->db->query("SELECT * FROM $this->table WHERE mhs_id = :mhs_id");
        $this->db->bind('mhs_id', $mhs_id);
        return $this->db->single();
    }
}
