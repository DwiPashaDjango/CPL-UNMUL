<?php

class Jurusan_Model
{
    private $table = 'jurusan';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllJurusan()
    {
        $this->db->query("SELECT * FROM $this->table WHERE kd_jrs != :kd_jrs");
        $this->db->bind('kd_jrs', 'BAAK-0001');
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function importJrs($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['kd_jrs'] != NULL && $data[$i]['name_jurusan'] != NULL) {
                $this->db->query(
                    "INSERT INTO $this->table (kd_jrs, name_jurusan) VALUES (:kd_jrs, :name_jurusan)"
                );
                $this->db->bind('kd_jrs', $data[$i]['kd_jrs']);
                $this->db->bind('name_jurusan', $data[$i]['name_jurusan']);
                $this->db->execute();
            }
        }
        return $this->db->rowCount();
    }

    public function getJurusan($kd_jrs)
    {
        $this->db->query("SELECT * FROM $this->table WHERE kd_jrs = :kd_jrs");
        $this->db->bind('kd_jrs', $kd_jrs);
        return $this->db->single();
    }

    public function addJurusan($data)
    {
        $queryMaxId = "SELECT MAX(id_jrs) AS kd_terbesar FROM $this->table";
        $this->db->query($queryMaxId);
        $result = $this->db->single();

        $urutan = (int) substr($result['kd_terbesar'], -3);
        $urutan++;

        $kodeJrs = $data['kd_jurusan'] . sprintf("%04s", $urutan);

        $queryInsert = "INSERT INTO $this->table(kd_jrs, name_jurusan) VALUES(:kd_jrs, :name_jurusan)";
        $this->db->query($queryInsert);
        $this->db->bind(':kd_jrs', $kodeJrs);
        $this->db->bind(':name_jurusan', $data['name_jurusan']);
        $this->db->execute();
    }

    public function updateJurusan($data)
    {
        $this->db->query("UPDATE $this->table SET name_jurusan = :name_jurusan WHERE kd_jrs = :kd_jrs");
        $this->db->bind('name_jurusan', $data['name_jurusan']);
        $this->db->bind('kd_jrs', $data['kd_jrs']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function deleteJrs($id_jrs)
    {
        $this->db->query("DELETE FROM $this->table WHERE id_jrs = :id_jrs");
        $this->db->bind('id_jrs', $id_jrs);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateCpCount($data)
    {
        $this->db->query("UPDATE $this->table SET batas = :batas, cp_count = :cp_count WHERE kd_jrs = :kd_jrs");
        $this->db->bind('batas', $data['batas']);
        $this->db->bind('cp_count', $data['cp_count']);
        $this->db->bind('kd_jrs', $data['kd_jrs']);

        return $this->db->resultSet();
    }
}
