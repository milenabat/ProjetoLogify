<?php

require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController
{
    public function listar()
    {
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->listarTodos();

        require_once __DIR__ . '/../views/usuarios/listar.php';
    }

    public function abrirFormularioCadastro()
    {
        require_once __DIR__ . '/../views/usuarios/cadastrar.php';
    }

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $plano = $_POST['plano'];

            $usuarioModel = new Usuario();
            $sucesso = $usuarioModel->cadastrar($nome, $email, $senha, $plano);

            if ($sucesso) {
                header("Location: /ProjetoLogify/public/?acao=usuarios");
                exit;
            } else {
                echo "Erro ao cadastrar usuário.";
            }

            
        }


        
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