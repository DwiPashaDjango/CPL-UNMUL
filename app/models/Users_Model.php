<?php

class Users_Model
{
    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getusersAdmin()
    {
        $this->db->query("SELECT * FROM $this->table WHERE roles = :roles");
        $this->db->bind('roles', 'admin');
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function getAdminById($id_user)
    {
        $this->db->query("SELECT * FROM $this->table WHERE id_user = :id_user");
        $this->db->bind('id_user', $id_user);
        return $this->db->single();
    }

    public function createAdmin($data)
    {
        $this->db->query("INSERT INTO $this->table (roles, kd_jrs, name, email, password) VALUES (:roles, :kd_jrs, :name, :email, :password)");
        $this->db->bind('roles', 'admin');
        $this->db->bind('kd_jrs', 'BAAK-0001');
        $this->db->bind('name', $data['name']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateAdmin($data)
    {
        $this->db->query("UPDATE $this->table SET name = :name, email = :email WHERE id_user = :id_user");
        $this->db->bind('name', $data['name']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('id_user', $data['id_user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function deleteAdmin($id_user)
    {
        $this->db->query("DELETE FROM $this->table WHERE id_user = :id_user");
        $this->db->bind('id_user', $id_user);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function getAllDosen()
    {
        $this->db->query("SELECT $this->table.*,
                          jurusan.kd_jrs, jurusan.name_jurusan
                          FROM $this->table 
                          INNER JOIN jurusan ON jurusan.kd_jrs = $this->table.kd_jrs
                          WHERE $this->table.roles = :roles
                          ORDER BY name ASC");
        $this->db->bind('roles', 'kaprodi');
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function getDosenById($id_user)
    {
        $this->db->query("SELECT * FROM $this->table WHERE id_user = :id_user");
        $this->db->bind('id_user', $id_user);
        return $this->db->single();
    }

    public function storeDosen($data)
    {
        $this->db->query("INSERT INTO $this->table (roles, kd_jrs, name, nidn, email, password) VALUES (:roles, :kd_jrs, :name, :nidn, :email, :password)");
        $this->db->bind('roles', 'kaprodi');
        $this->db->bind('kd_jrs', $data['kd_jrs']);
        $this->db->bind('nidn', $data['nidn']);
        $this->db->bind('name', $data['name']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateDosen($data)
    {
        $this->db->query("UPDATE $this->table SET name = :name, email = :email, nidn = :nidn, kd_jrs = :kd_jrs WHERE id_user = :id_user");
        $this->db->bind('kd_jrs', $data['kd_jrs']);
        $this->db->bind('nidn', $data['nidn']);
        $this->db->bind('name', $data['name']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('id_user', $data['id_user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function deleteDosen($id_user)
    {
        $this->db->query("DELETE FROM $this->table WHERE id_user = :id_user");
        $this->db->bind('id_user', $id_user);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function resetPw($data)
    {
        $this->db->query("UPDATE users SET password = :password WHERE id_user = :id_user");
        $this->db->bind('password', password_hash($data['password_update'], PASSWORD_DEFAULT));
        $this->db->bind('id_user', $data['id_user_pw']);
        $this->db->execute();

        return $this->db->rowCount();
    }
}
