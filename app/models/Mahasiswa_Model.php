<?php

class Mahasiswa_Model
{
    private $table = 'mahasiswa';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllMhs($limit, $offset, $kd_jrs)
    {
        $this->db->query(
            "SELECT $this->table.*, jurusan.name_jurusan
            FROM $this->table
            INNER JOIN jurusan ON jurusan.kd_jrs = $this->table.kd_jrs
            WHERE $this->table.kd_jrs = :kd_jrs
            ORDER BY $this->table.angkatan DESC
            LIMIT $offset, $limit"
        );
        $this->db->bind('kd_jrs', $kd_jrs);
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function searchAllMhs($limit, $offset, $search, $kd_jrs)
    {
        $this->db->query(
            "SELECT $this->table.*, jurusan.name_jurusan
            FROM $this->table
            INNER JOIN jurusan ON jurusan.kd_jrs = $this->table.kd_jrs
            WHERE ($this->table.name LIKE CONCAT('%', :search, '%')
                OR $this->table.nrp LIKE CONCAT('%', :search, '%')
                OR $this->table.angkatan LIKE CONCAT('%', :search, '%'))
            AND $this->table.kd_jrs = :kd_jrs
            ORDER BY $this->table.angkatan DESC
            LIMIT $offset, $limit"
        );
        $this->db->bind('search', $search);
        $this->db->bind('kd_jrs', $kd_jrs);
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function getTotalMhs($kd_jrs)
    {
        $query = "SELECT COUNT(*) as total FROM $this->table WHERE kd_jrs = :kd_jrs";
        $this->db->query($query);
        $this->db->bind('kd_jrs', $kd_jrs);
        $this->db->execute();
        $result = $this->db->single();
        return $result['total'];
    }

    public function getTotalPages($limit, $kd_jrs)
    {
        $totalData = $this->getTotalMhs($kd_jrs);
        $totalPages = ceil($totalData / $limit);
        return $totalPages;
    }

    public function getMhsByJrs($kd_jrs)
    {
        $this->db->query(
            "SELECT $this->table.id_mhs, $this->table.name, $this->table.nrp, $this->table.email, $this->table.kd_jrs, $this->table.angkatan,
             jurusan.kd_jrs, jurusan.name_jurusan
             FROM $this->table
             INNER JOIN jurusan ON jurusan.kd_jrs = $this->table.kd_jrs
             WHERE $this->table.kd_jrs = :kd_jrs AND status = :status
             ORDER BY angkatan DESC"
        );
        $this->db->bind('kd_jrs', $kd_jrs);
        $this->db->bind('status', 0);
        return $this->db->resultSet();
    }

    public function getMhsByJrsEvaluasi($kd_jrs)
    {
        $this->db->query(
            "SELECT $this->table.id_mhs, $this->table.name, $this->table.nrp, $this->table.email, $this->table.kd_jrs, $this->table.angkatan,
             jurusan.kd_jrs, jurusan.name_jurusan
             FROM $this->table
             INNER JOIN jurusan ON jurusan.kd_jrs = $this->table.kd_jrs
             WHERE $this->table.kd_jrs = :kd_jrs
             ORDER BY angkatan DESC"
        );
        $this->db->bind('kd_jrs', $kd_jrs);
        return $this->db->resultSet();
    }


    public function getMhsByLulus($kd_jrs)
    {
        $this->db->query(
            "SELECT $this->table.id_mhs, $this->table.name, $this->table.nrp, $this->table.email, $this->table.kd_jrs,
             jurusan.kd_jrs, jurusan.name_jurusan
             FROM $this->table
             INNER JOIN jurusan ON jurusan.kd_jrs = $this->table.kd_jrs
             WHERE $this->table.kd_jrs = :kd_jrs AND status = :status
             ORDER BY name ASC"
        );
        $this->db->bind('kd_jrs', $kd_jrs);
        $this->db->bind('status', 1);
        return $this->db->resultSet();
    }

    public function getMhsById($id_mhs)
    {
        $this->db->query("SELECT * FROM $this->table WHERE id_mhs = :id_mhs");
        $this->db->bind('id_mhs', $id_mhs);
        return $this->db->single();
    }

    public function filterMhs($data)
    {
        $query = "SELECT $this->table.id_mhs, $this->table.name, $this->table.nrp, $this->table.email, $this->table.kd_jrs, $this->table.angkatan,
            jurusan.kd_jrs, jurusan.name_jurusan
            FROM $this->table
            INNER JOIN jurusan ON jurusan.kd_jrs = $this->table.kd_jrs
            WHERE angkatan IN (";

        $placeholders = '';
        for ($i = 0; $i < count($data); $i++) {
            $placeholders .= ':angkatan' . $i;
            if ($i < count($data) - 1) {
                $placeholders .= ', ';
            }
        }
        $query .= $placeholders . ") AND jurusan.kd_jrs = :kd_jrs AND status = :status ORDER BY $this->table.angkatan DESC";

        $this->db->query($query);

        for ($i = 0; $i < count($data); $i++) {
            $this->db->bind('angkatan' . $i, $data[$i]['angkatan']);
            $this->db->bind('kd_jrs', $data[$i]['kd_jrs']);
        }
        $this->db->bind('status', 0);
        $this->db->execute();

        return $this->db->resultSet();
    }

    public function getMhsByNrp($id_mhs)
    {
        $this->db->query("SELECT $this->table.*,
                          jurusan.kd_jrs, jurusan.name_jurusan
                          FROM $this->table 
                          INNER JOIN jurusan ON jurusan.kd_jrs = $this->table.kd_jrs
                          WHERE id_mhs = :id_mhs");
        $this->db->bind('id_mhs', $id_mhs);
        return $this->db->single();
    }

    public function importMhs($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['name'] != NULL && $data[$i]['nrp'] != NULL && $data[$i]['email'] != NULL && $data[$i]['kd_jrs'] != NULL) {
                $this->db->query(
                    "INSERT INTO $this->table (name, nrp, email, kd_jrs, angkatan, strata) VALUES (:name, :nrp, :email, :kd_jrs, :angkatan, :strata)"
                );
                $this->db->bind('name', $data[$i]['name']);
                $this->db->bind('nrp', $data[$i]['nrp']);
                $this->db->bind('email', $data[$i]['email']);
                $this->db->bind('kd_jrs', $data[$i]['kd_jrs']);
                $this->db->bind('angkatan', $data[$i]['angkatan']);
                $this->db->bind('strata', $data[$i]['strata']);
                $this->db->execute();
            }
        }
        return $this->db->rowCount();
    }

    public function updateMhs($data)
    {
        $this->db->query("UPDATE $this->table SET name = :name, nrp = :nrp, email = :email WHERE id_mhs = :id_mhs");
        $this->db->bind('name', $data['name']);
        $this->db->bind('nrp', $data['nrp']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('id_mhs', $data['id_mhs']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function deleteMhs($id_mhs)
    {
        $this->db->query("DELETE FROM $this->table WHERE id_mhs = :id_mhs");
        $this->db->bind('id_mhs', $id_mhs);
        $this->db->execute();

        $this->db->query("DELETE FROM mahasiswa_matakuliah WHERE mhs_id = :id_mhs");
        $this->db->bind('id_mhs', $id_mhs);
        $this->db->execute();

        $this->db->query("DELETE FROM nilai WHERE mhs_id = :id_mhs");
        $this->db->bind('id_mhs', $id_mhs);
        $this->db->execute();

        return $this->db->resultSet();
    }
}
