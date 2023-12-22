<?php

class Flasher
{
    public static function setFlash($pesan, $aksi, $tipe)
    {
        $_SESSION['flash'] = [
            'pesan' => $pesan,
            'aksi'  => $aksi,
            'tipe'  => $tipe
        ];
    }

    public static function flash()
    {
        if (isset($_SESSION['flash'])) {
            echo ' <div class="alert alert-' . $_SESSION['flash']['tipe'] . ' alert-dismissible fade show" role="alert">
                        ' . $_SESSION['flash']['pesan'] . $_SESSION['flash']['aksi'] . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            unset($_SESSION['flash']);
        }
    }

    public static function setValidation($pesan)
    {
        $_SESSION['validation'] = [
            'pesan' => $pesan
        ];
    }

    public static function validationFlash()
    {
        if (isset($_SESSION['validation'])) {
            echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">Errors</h4>';
            foreach ($_SESSION['validation']['pesan'] as $value) {
                echo '<ul><li>' . $value . '</li></ul>';
            }
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>';
            unset($_SESSION['validation']);
        }
    }
}
