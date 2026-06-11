<?php

class AuthGuard
{
    public static function usuario()
    {
        if (!isset($_SESSION['usuario'])) {
            header("Location: /ProjetoLogify/public/?acao=login");
            exit;
        }
    }

    public static function admin()
    {
        if (!isset($_SESSION['admin'])) {
            header("Location: /ProjetoLogify/public/?acao=login");
            exit;
        }
    }
}