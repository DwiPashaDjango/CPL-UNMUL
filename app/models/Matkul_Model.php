<?php

class Matkul_Model
{
    private $table = 'matkul';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllCp()
    {
        $user_id = $_SESSION['user_id'];
        $kd_jrs = $_SESSION['kd_jrs'];
        $this->db->query(
            "SELECT $this->table.*, mata_kuliah.nm_mk, mata_kuliah.kd_mk, mata_kuliah.sks
             FROM $this->table 
             INNER JOIN mata_kuliah ON mata_kuliah.kd_mk = $this->table.kd_mk
             WHERE user_id = :user_id AND mata_kuliah.kd_jrs = :kd_jrs"
        );
        $this->db->bind('user_id', $user_id);
        $this->db->bind('kd_jrs', $kd_jrs);
        $this->db->execute();

        return $this->db->resultSet();
    }

    public function getMatkul()
    {
        $user_id = $_SESSION['user_id'];
        $kd_jrs = $_SESSION['kd_jrs'];
        $this->db->query(
            "SELECT $this->table.*, mata_kuliah.nm_mk, mata_kuliah.kd_mk, mata_kuliah.sks, mahasiswa_matakuliah.mhs_id
             FROM $this->table 
             INNER JOIN mata_kuliah ON mata_kuliah.kd_mk = $this->table.kd_mk
             INNER JOIN mahasiswa_matakuliah ON mahasiswa_matakuliah.kd_mk = $this->table.kd_mk
             WHERE user_id = :user_id AND mata_kuliah.kd_jrs = :kd_jrs"
        );
        $this->db->bind('user_id', $user_id);
        $this->db->bind('kd_jrs', $kd_jrs);
        $this->db->execute();

        return $this->db->resultSet();
    }

    public function sumCp($cp_count)
    {
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT";
        for ($i = 1; $i <= $cp_count; $i++) {
            $sql .= " SUM(cp_$i) AS cp_$i";
            if ($i < $cp_count) {
                $sql .= ",";
            }
        }
        $query = $sql . " FROM $this->table WHERE user_id = :user_id";
        $this->db->query($query);
        $this->db->bind('user_id', $user_id);

        $result = $this->db->single();

        for ($i = 1; $i <= $cp_count; $i++) {
            $columnName = "cp_$i";
            $sums[$columnName] = $result[$columnName];
        }

        return $sums;
    }

    public function getMatkulByIdCp($id_cp)
    {
        $this->db->query("SELECT * FROM $this->table WHERE id_cp = :id_cp");
        $this->db->bind('id_cp', $id_cp);
        return $this->db->single();
    }

    public function insertMatkul($data)
    {
        $cpCount = $data['cp_count'];

        $user_id = $_SESSION['user_id'];
        $this->db->query(
            "INSERT INTO $this->table 
             (kd_mk, user_id, cp_1, cp_2, cp_3, cp_4, cp_5, cp_6, cp_7, cp_8, cp_9, cp_10, cp_11, cp_12, cp_13, cp_14, cp_15, cp_16, cp_17, cp_18, cp_19, cp_20, created_at)
             VALUES (:kd_mk, :user_id, :cp_1, :cp_2, :cp_3, :cp_4, :cp_5, :cp_6, :cp_7, :cp_8, :cp_9, :cp_10, :cp_11, :cp_12, :cp_13, :cp_14, :cp_15, :cp_16, :cp_17, :cp_18, :cp_19, :cp_20, :created_at)"
        );

        for ($i = 1; $i <= 20; $i++) {
            $cp_key = 'cp_' . $i;
            $cp_value = ($i > $cpCount) ? 0 : $data['data'][$cp_key];

            if ($cp_value === '') {
                $cp_value = 0;
            }
            $this->db->bind('cp_' . $i, $cp_value);
        }

        $this->db->bind('kd_mk', $data['data']['kd_mk']);
        $this->db->bind('user_id', $user_id);
        $this->db->bind('created_at', date('Y-m-d H:i:s'));
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateMatkul($data)
    {
        $cpCount = $data['cp_count'];

        $this->db->query(
            "UPDATE $this->table 
			 SET cp_1 = :cp_1, cp_2 = :cp_2, cp_3 = :cp_3, cp_4 = :cp_4, cp_5 = :cp_5, 
			 cp_6 = :cp_6, cp_7 = :cp_7, cp_8 = :cp_8, cp_9 = :cp_9, cp_10 = :cp_10, cp_11 = :cp_11, cp_12 = :cp_12, 
			 cp_13 = :cp_13, cp_14 = :cp_14, cp_15 = :cp_15, cp_16 = :cp_16, cp_17 = :cp_17, cp_18 = :cp_18, cp_19 = :cp_19, 
			 cp_20 = :cp_20
			 WHERE id_cp = :id_cp"
        );

        for ($i = 1; $i <= 20; $i++) {
            $cp_key = 'cp_' . $i . '_update';
            $cp_value = ($i > $cpCount) ? 0 : $data[$cp_key];

            $this->db->bind('cp_' . $i, $cp_value);
        }

        $this->db->bind('id_cp', $data['id_cp']);
        $this->db->execute();


        return $this->db->rowCount();
    }

    public function deleteCp($id_cp)
    {
        $this->db->query("DELETE FROM $this->table WHERE id_cp = :id_cp");
        $this->db->bind('id_cp', $id_cp);
        $this->db->execute();

        return $this->db->resultSet();
    }
}
