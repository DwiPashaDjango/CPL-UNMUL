<?php

class Auth_Model
{
    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function setLogin($data)
    {
        $this->db->query("SELECT * FROM $this->table WHERE nidn = :nidn OR email = :email");
        $this->db->bind('nidn', $data['username']);
        $this->db->bind('email', $data['username']);

        $user = $this->db->single();

        if ($user) {
            if (password_verify($data['password'], $user['password'])) {
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['kd_jrs'] = $user['kd_jrs'];
                header('Location: ' . BASE_URL . 'Dashboard');
                exit;
            } else {
                Flasher::setFlash('Nidn Atau ', ' Password Salah.', 'danger');
                header('Location: ' . BASE_URL);
                exit;
            }
        } else {
            Flasher::setFlash('Akun', ' Tidak Terdaftar.', 'danger');
            header('Location: ' . BASE_URL);
            exit;
        }
    }

    public function getUserLogin()
    {
        $id_user = $_SESSION['user_id'];
        $this->db->query("SELECT $this->table.name, $this->table.nidn, $this->table.roles,
                          jurusan.cp_count, jurusan.kd_jrs, jurusan.name_jurusan, jurusan.batas
                          FROM $this->table 
                          INNER JOIN jurusan ON jurusan.kd_jrs = $this->table.kd_jrs
                          WHERE $this->table.id_user = :id_user");
        $this->db->bind('id_user', $id_user);

        return $this->db->single();
    }
}
