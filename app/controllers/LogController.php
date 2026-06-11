<?php

require_once __DIR__ . '/../models/Log.php';
require_once __DIR__ . '/../models/Projeto.php';

class LogController
{
    public function listar()
    {
        $logModel = new Log();
        $logs = $logModel->listarTodos();

        require_once __DIR__ . '/../views/logs/listar.php';

        require_once __DIR__ . '/../core/AuthGuard.php';

AuthGuard::usuario();
    }

    public function abrirFormularioCadastro()
    {
        $projetoModel = new Projeto();
        $projetos = $projetoModel->listarTodos();

        require_once __DIR__ . '/../views/logs/cadastrar.php';
    }

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $mensagem = $_POST['mensagem'];
            $id_projeto = $_POST['id_projeto'];

            $logModel = new Log();
            $sucesso = $logModel->cadastrar($mensagem, $id_projeto);

            if ($sucesso) {
                header("Location: /ProjetoLogify/public/?acao=logs");
                exit;
            } else {
                echo "Erro ao cadastrar log.";
            }
        }
    }
    public function editar()
{
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $logModel = new Log();
        $projetoModel = new Projeto();

        $log = $logModel->buscarPorId($id);
        $projetos = $projetoModel->listarTodos();

        require_once __DIR__ . '/../views/logs/editar.php';
    } else {
        echo "ID do log não informado.";
    }
}

public function atualizar()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_log = $_POST['id_log'];
        $mensagem = $_POST['mensagem'];
        $id_projeto = $_POST['id_projeto'];

        $logModel = new Log();
        $sucesso = $logModel->atualizar($id_log, $mensagem, $id_projeto);

        if ($sucesso) {
            header("Location: /ProjetoLogify/public/?acao=logs");
            exit;
        } else {
            echo "Erro ao atualizar log.";
        }
    }
}
public function excluir()
{
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $logModel = new Log();
        $sucesso = $logModel->excluir($id);

        if ($sucesso) {
            header("Location: /ProjetoLogify/public/?acao=logs");
            exit;
        } else {
            echo "Erro ao excluir log.";
        }
    } else {
        echo "ID não informado.";
    }
}
}