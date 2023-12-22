<?php

class Middleware
{
    public static function auth()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL);
            exit;
        }
    }
}
