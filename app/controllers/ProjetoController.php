<?php
// app/controllers/ProjetoController.php

require_once __DIR__ . '/../models/Projeto.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Log.php';
require_once __DIR__ . '/../core/AuthGuard.php';

class ProjetoController
{
    public function __construct()
    {
        // Bloqueia acessos de quem não é usuário comum logado
        AuthGuard::usuario();
    }

    public function listar()
    {
        $projetoModel = new Projeto();
        $projetos = $projetoModel->listarTodos();
        require_once __DIR__ . '/../views/projetos/listar.php';
    }


    public function abrirFormularioCadastro()
    {
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->listarTodos();

        require_once __DIR__ . '/../views/projetos/cadastrar.php';
    }

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nome_projeto = $_POST['nome_projeto'];
            $id_usuario = $_POST['id_usuario'];

            $projetoModel = new Projeto();
            $sucesso = $projetoModel->cadastrar($nome_projeto, $id_usuario);

            if ($sucesso) {
                header("Location: /ProjetoLogify/public/?acao=projetos");
                exit;
            } else {
                echo "Erro ao cadastrar projeto.";
            }
        }
    }

    public function editar()
    {
        if (isset($_GET['id'])) {

            $id = $_GET['id'];

            $projetoModel = new Projeto();
            $usuarioModel = new Usuario();

            $projeto = $projetoModel->buscarPorId($id);
            $usuarios = $usuarioModel->listarTodos();

            require_once __DIR__ . '/../views/projetos/editar.php';

        } else {
            echo "ID do projeto não informado.";
        }
    }

    public function atualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id_projeto = $_POST['id_projeto'];
            $nome_projeto = $_POST['nome_projeto'];
            $id_usuario = $_POST['id_usuario'];

            $projetoModel = new Projeto();
            $sucesso = $projetoModel->atualizar($id_projeto, $nome_projeto, $id_usuario);

            if ($sucesso) {
                header("Location: /ProjetoLogify/public/?acao=projetos");
                exit;
            } else {
                echo "Erro ao atualizar projeto.";
            }
        }
    }

    public function excluir()
    {
        if (isset($_GET['id'])) {

            $id = $_GET['id'];

            $projetoModel = new Projeto();
            $sucesso = $projetoModel->excluir($id);

            if ($sucesso) {
                header("Location: /ProjetoLogify/public/?acao=projetos");
                exit;
            } else {
                echo "Erro ao excluir projeto.";
            }

        } else {
            echo "ID não informado.";
        }
    }

    public function analisarLogs()
    {
        if (isset($_GET['id'])) {

            $id_projeto = $_GET['id'];

            $projetoModel = new Projeto();
            $logModel = new Log();

            $projeto = $projetoModel->buscarPorId($id_projeto);
            $logs = $logModel->listarPorProjeto($id_projeto);

            require_once __DIR__ . '/../views/projetos/logs.php';

        } else {
            echo "ID do projeto não informado.";
        }
    }
}