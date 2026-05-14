<?php

require_once __DIR__ . '/../models/Fatura.php';
require_once __DIR__ . '/../models/Usuario.php';

class FaturaController
{
    public function listar()
    {
        $faturaModel = new Fatura();
        $faturas = $faturaModel->listarTodos();

        require_once __DIR__ . '/../views/faturas/listar.php';
    }

    public function abrirFormularioCadastro()
    {
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->listarTodos();

        require_once __DIR__ . '/../views/faturas/cadastrar.php';
    }

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_usuario = $_POST['id_usuario'];
            $valor = $_POST['valor'];
            $status = $_POST['status'];

            $faturaModel = new Fatura();
            $sucesso = $faturaModel->cadastrar($id_usuario, $valor, $status);

            if ($sucesso) {
                header("Location: /ProjetoLogify/public/?acao=faturas");
                exit;
            } else {
                echo "Erro ao cadastrar fatura.";
            }
        }
    }
    public function editar()
{
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $faturaModel = new Fatura();
        $usuarioModel = new Usuario();

        $fatura = $faturaModel->buscarPorId($id);
        $usuarios = $usuarioModel->listarTodos();

        require_once __DIR__ . '/../views/faturas/editar.php';
    } else {
        echo "ID da fatura não informado.";
    }
}

public function atualizar()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_fatura = $_POST['id_fatura'];
        $id_usuario = $_POST['id_usuario'];
        $valor = $_POST['valor'];
        $status = $_POST['status'];

        $faturaModel = new Fatura();
        $sucesso = $faturaModel->atualizar($id_fatura, $id_usuario, $valor, $status);

        if ($sucesso) {
            header("Location: /ProjetoLogify/public/?acao=faturas");
            exit;
        } else {
            echo "Erro ao atualizar fatura.";
        }
    }
}


public function excluir()
{
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $faturaModel = new Fatura();
        $sucesso = $faturaModel->excluir($id);

        if ($sucesso) {
            header("Location: /ProjetoLogify/public/?acao=faturas");
            exit;
        } else {
            echo "Erro ao excluir fatura.";
        }
    } else {
        echo "ID da fatura não informado.";
    }
}

}