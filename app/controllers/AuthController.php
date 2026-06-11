<?php
// app/controllers/AuthController.php

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

            // Garante sessão ativa
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->buscarPorEmail($email);

            // 🔥 A MÁGICA DA SEGURANÇA: Usando password_verify
            // Se o usuário não existir OU a senha não bater com a hash do banco, ele barra
            if (!$usuario || !password_verify($senha, $usuario['senha'])) {
                echo "Login inválido";
                return;
            }

            // 🔥 separação admin / user
            if ($usuario['tipo'] === 'admin') {
                $_SESSION['admin'] = $usuario;
                header("Location: /ProjetoLogify/public/?acao=admin_dashboard");
                exit;
            }

            $_SESSION['usuario'] = $usuario;
            header("Location: /ProjetoLogify/public/?acao=projetos");
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
    // Abre a tela HTML do formulário
    public function cadastrar()
    {
        require_once __DIR__ . '/../views/auth/cadastrar.php';
    }

    // Recebe os dados do formulário e salva
    public function salvarCadastro()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            if (!empty($nome) && !empty($email) && !empty($senha)) {
                
                $usuarioModel = new Usuario();

                // Verifica se o email já existe para não ter duplicação
                if ($usuarioModel->buscarPorEmail($email)) {
                    echo "Este e-mail já está em uso!";
                    return;
                }

                if ($usuarioModel->cadastrar($nome, $email, $senha)) {
                    // Se salvou com sucesso, joga para o login
                    header("Location: /ProjetoLogify/public/?acao=login");
                    exit;
                } else {
                    echo "Erro ao cadastrar no banco de dados.";
                }
            } else {
                echo "Preencha todos os campos obrigatórios.";
            }
        }
    }}