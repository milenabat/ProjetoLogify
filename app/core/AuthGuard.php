<?php
// app/core/AuthGuard.php

class AuthGuard
{
    public static function usuario()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header("Location: /ProjetoLogify/public/?acao=login");
            exit;
        }
    }

    public static function admin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['admin'])) {
            header("Location: /ProjetoLogify/public/?acao=login");
            exit;
        }
    }
}