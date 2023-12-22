<?php

class Auth extends Controller
{
    public function index()
    {
        try {
            $data['title'] = 'Login';

            $this->view('auth/login');
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function login()
    {
        try {
            $errors = [];

            if (empty($_POST['username'])) {
                $errors['username'] = "Silahkan Masukan Nidn Atau Email Saudara.";
            }

            if (empty($_POST['password'])) {
                $errors['password'] = "Silahkan Masukan Password Akun Saudara.";
            }

            if (empty($errors)) {
                $this->model('Auth_Model')->setLogin($_POST);
            } else {
                Flasher::setValidation($errors);
                header("Location: " . BASE_URL);
                exit;
            }
        } catch (PDOException $err) {
            var_dump($err);
            die;
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        header("Location: " . BASE_URL);
    }
}
