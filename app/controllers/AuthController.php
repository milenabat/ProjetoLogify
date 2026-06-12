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
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        require_once __DIR__ . '/../models/Usuario.php';
        $usuarioModel = new Usuario();
        $user = $usuarioModel->buscarPorEmail($email);

        if ($user && password_verify($senha, $user['senha'])) {
            
            // 🔥 A MÁGICA AQUI: Antes de logar o novo usuário, limpa qualquer "fantasma" que tenha ficado no navegador!
            session_unset(); 

            // Verifique se a sua coluna no banco se chama 'tipo', 'perfil', etc.
            if ($user['tipo'] === 'admin') {
                $_SESSION['admin'] = $user;
                header("Location: /ProjetoLogify/public/?acao=admin_dashboard");
                exit;
            } else {
                $_SESSION['usuario'] = $user;
                header("Location: /ProjetoLogify/public/?acao=projetos");
                exit;
            }

        } else {
            echo "<script>alert('E-mail ou senha incorretos!'); window.location.href='/ProjetoLogify/public/?acao=login';</script>";
            exit;
        }
    }

    public function logout()
    {
        // 🔥 Limpeza TOTAL da memória do servidor
        session_unset(); // Limpa as variáveis
        session_destroy(); // Destrói a sessão inteira
        
        // Joga de volta pra tela de login
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