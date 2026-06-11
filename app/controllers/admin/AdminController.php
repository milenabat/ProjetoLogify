<?php
// app/controllers/admin/AdminController.php

require_once __DIR__ . '/../../core/AuthGuard.php';

class AdminController
{
    public function __construct()
    {
        // Protege TODAS as funções deste controller automaticamente
        AuthGuard::admin();
    }

    public function dashboard()
    {
        require_once __DIR__ . '/../../views/admin/dashboard.php';
    }

    public function faturas()
    {
        require_once __DIR__ . '/../../views/admin/faturas.php';
    }

    public function comprovantes()
    {
        require_once __DIR__ . '/../../views/admin/comprovantes.php';
    }
}