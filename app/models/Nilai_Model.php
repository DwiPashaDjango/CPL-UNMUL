<?php

class Nilai_Model
{
    private $table = 'nilai';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getNilaiRelation($mhs_id)
    {
        $kd_jrs = $_SESSION['kd_jrs'];
        $this->db->query(
            "SELECT
                $this->table.mhs_id,
                $this->table.bobot,
                mata_kuliah.*,
                nilai.id_nilai
            FROM
                $this->table
            INNER JOIN mata_kuliah ON mata_kuliah.kd_mk = $this->table.kd_mk
            WHERE $this->table.mhs_id = :mhs_id AND mata_kuliah.kd_jrs = :kd_jrs
            GROUP BY $this->table.mhs_id, $this->table.kd_mk, mata_kuliah.nm_mk, nilai.id_nilai, mata_kuliah.id_mk
            "
        );
        $this->db->bind('mhs_id', $mhs_id);
        $this->db->bind('kd_jrs', $kd_jrs);
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function getNilaiMhsJrs()
    {
        $user_id = $_SESSION['user_id'];
        $kd_jrs = $_SESSION['kd_jrs'];
        $this->db->query(
            "SELECT
                $this->table.mhs_id,
                $this->table.bobot,
                matkul.kd_mk,
                mata_kuliah.*,
                nilai.id_nilai
            FROM
                $this->table
            INNER JOIN matkul ON matkul.kd_mk = $this->table.kd_mk
            INNER JOIN mata_kuliah ON mata_kuliah.kd_mk = $this->table.kd_mk
            WHERE $this->table.user_id = :user_id AND mata_kuliah.kd_jrs = :kd_jrs
            GROUP BY $this->table.mhs_id, $this->table.kd_mk, mata_kuliah.nm_mk, nilai.id_nilai, mata_kuliah.id_mk
            "
        );
        $this->db->bind('kd_jrs', $kd_jrs);
        $this->db->bind('user_id', $user_id);
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function getNilaiById($id_nilai)
    {
        $this->db->query(
            "SELECT $this->table.*, 
             mahasiswa.name 
             FROM $this->table 
             INNER JOIN mahasiswa ON mahasiswa.id_mhs = $this->table.mhs_id 
             WHERE $this->table.id_nilai = :id_nilai"
        );
        $this->db->bind('id_nilai', $id_nilai);
        return $this->db->single();
    }

    public function storeNilai($data)
    {
        $this->db->query("INSERT INTO $this->table (user_id, mhs_id, kd_mk, bobot) VALUES (:user_id, :mhs_id, :kd_mk, :bobot)");
        $this->db->bind('user_id', $_SESSION['user_id']);
        $this->db->bind('mhs_id', $data['mhs_id']);
        $this->db->bind('kd_mk', $data['kd_mk']);
        $this->db->bind('bobot', $data['bobot']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function createNilai($data)
    {
        $user_id = $_SESSION['user_id'];
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['kd_mk'] != NULL && $data[$i]['nm_mk'] != NULL && $data[$i]['bobot'] != NULL && $data[$i]['mhs_id']) {
                $this->db->query(
                    "INSERT INTO $this->table (user_id, mhs_id, kd_mk, bobot) VALUES (:user_id, :mhs_id, :kd_mk, :bobot)"
                );
                $this->db->bind('user_id', $user_id);
                $this->db->bind('mhs_id', $data[$i]['mhs_id']);
                $this->db->bind('kd_mk', $data[$i]['kd_mk']);
                $this->db->bind('bobot', $data[$i]['bobot']);
                $this->db->execute();
            }
        }
        return $this->db->rowCount();
    }

    public function updateNilai($data)
    {
        $this->db->query("UPDATE $this->table SET bobot = :bobot WHERE id_nilai = :id_nilai");
        $this->db->bind('bobot', $data['bobot_update']);
        $this->db->bind('id_nilai', $data['id_nilai']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function deleteNilai($id_nilai)
    {
        $this->db->query("DELETE FROM $this->table WHERE id_nilai = :id_nilai");
        $this->db->bind('id_nilai', $id_nilai);
        $this->db->execute();

        return $this->db->resultSet();
    }
}
