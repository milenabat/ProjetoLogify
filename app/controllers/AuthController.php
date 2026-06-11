<?php

require_once __DIR__ . '/../models/Usuario.php';

class AuthController
{
    public function login()
    {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function autenticar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // 🔥 segurança: garante sessão ativa
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->buscarPorEmail($email);

            if (!$usuario || $usuario['senha'] !== $senha) {
                echo "Login inválido";
                return;
            }

            // 🔥 separação admin / user
            if ($usuario['tipo'] === 'admin') {

                $_SESSION['admin'] = $usuario;

                header("Location: /ProjetoLogify/public/?admin=dashboard");
                exit;
            }

            $_SESSION['usuario'] = $usuario;

            header("Location: /ProjetoLogify/public/?acao=home");
            exit;
        }
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();

        header("Location: /ProjetoLogify/public/?acao=login");
        exit;
    }
}