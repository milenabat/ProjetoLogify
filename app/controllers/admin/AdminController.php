<?php
session_start();

class AdminController
{
    private function verificarAdmin()
    {require_once __DIR__ . '/../../core/AuthGuard.php';

AuthGuard::admin();
        if (!isset($_SESSION['admin'])) {
            header("Location: /ProjetoLogify/public/?acao=login");
            exit;
        }
    }

    public function dashboard()
    {
        $this->verificarAdmin();

        require_once __DIR__ . '/../../views/admin/dashboard.php';
    }

    public function faturas()
    {require_once __DIR__ . '/../../core/AuthGuard.php';

AuthGuard::admin();
        $this->verificarAdmin();

        require_once __DIR__ . '/../../views/admin/faturas.php';
    }

    public function comprovantes()
    {require_once __DIR__ . '/../../core/AuthGuard.php';

AuthGuard::admin();
        $this->verificarAdmin();

        require_once __DIR__ . '/../../views/admin/comprovantes.php';
    }
}