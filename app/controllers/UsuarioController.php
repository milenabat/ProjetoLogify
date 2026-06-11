<?php

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../core/AuthGuard.php'; // Adicionamos a importação do Guardião

class UsuarioController
{
    public function __construct()
    {
        // Blindagem: Garante que APENAS o administrador consiga acessar qualquer função desta classe
        AuthGuard::admin();
    }

    public function listar()
    {
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->listarTodos();

        require_once __DIR__ . '/../views/usuarios/listar.php';
    }

    public function editar()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->buscarPorId($id);

            require_once __DIR__ . '/../views/usuarios/editar.php';
        } else {
            echo "ID do usuário não informado.";
        }
    }

    public function atualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id_usuario'];
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $plano = $_POST['plano'];

            $usuarioModel = new Usuario();
            $sucesso = $usuarioModel->atualizar($id, $nome, $email, $senha, $plano);

            if ($sucesso) {
                header("Location: /ProjetoLogify/public/?acao=usuarios");
                exit;
            } else {
                echo "Erro ao atualizar usuário.";
            }
        }
    }

    public function excluir()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $usuarioModel = new Usuario();

            // Excelente validação de regra de negócio!
            $totalProjetos = $usuarioModel->contarProjetos($id);
            $totalFaturas = $usuarioModel->contarFaturas($id);

            if ($totalProjetos > 0 || $totalFaturas > 0) {
                echo "Não é possível excluir este usuário, pois ele possui projetos ou faturas vinculadas.";
                echo "<br><br>";
                echo "<a href='/ProjetoLogify/public/?acao=usuarios'>Voltar para usuários</a>";
                return;
            }

            $sucesso = $usuarioModel->excluir($id);

            if ($sucesso) {
                header("Location: /ProjetoLogify/public/?acao=usuarios");
                exit;
            } else {
                echo "Erro ao excluir usuário.";
            }
        } else {
            echo "ID não informado.";
        }
    }
}