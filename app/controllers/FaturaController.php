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
            $usuarioModel = new Usuario();

            $sucesso = $faturaModel->cadastrar($id_usuario, $valor, $status);

            if ($sucesso) {
                if ($status == 'pago') {
                    $usuarioModel->atualizarPlano($id_usuario, 'Pro');
                }

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
    echo "CHEGUEI NO MÉTODO ATUALIZAR FATURA<br>";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_fatura = $_POST['id_fatura'];
        $id_usuario = $_POST['id_usuario'];
        $valor = $_POST['valor'];
        $status = $_POST['status'];

        echo "ID Fatura: " . $id_fatura . "<br>";
        echo "ID Usuário: " . $id_usuario . "<br>";
        echo "Valor: " . $valor . "<br>";
        echo "Status recebido: " . $status . "<br>";

        $faturaModel = new Fatura();
        $usuarioModel = new Usuario();

        $sucesso = $faturaModel->atualizar($id_fatura, $id_usuario, $valor, $status);

        echo "Fatura atualizada? " . ($sucesso ? "SIM" : "NÃO") . "<br>";

        if ($status == 'pago') {
            echo "ENTROU NA REGRA DE PLANO PRO<br>";

            $atualizouUsuario = $usuarioModel->atualizarPlano($id_usuario, 'Pro');

            echo "Usuário atualizado para Pro? " . ($atualizouUsuario ? "SIM" : "NÃO") . "<br>";
        } else {
            echo "NÃO entrou na regra porque status não é pago<br>";
        }

        exit;
    } else {
        echo "Não veio via POST.";
    }
}
    public function pagar()
    {
        if (isset($_GET['id'])) {
            $id_fatura = $_GET['id'];

            $faturaModel = new Fatura();
            $usuarioModel = new Usuario();

            $fatura = $faturaModel->buscarPorId($id_fatura);

            if (!$fatura) {
                echo "Fatura não encontrada.";
                return;
            }

            $sucessoFatura = $faturaModel->marcarComoPago($id_fatura);

            if ($sucessoFatura) {
                $id_usuario = $fatura['id_usuario'];
                $usuarioModel->atualizarPlano($id_usuario, 'Pro');

                header("Location: /ProjetoLogify/public/?acao=faturas");
                exit;
            } else {
                echo "Erro ao marcar fatura como paga.";
            }
        } else {
            echo "ID da fatura não informado.";
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
    public function gerarPagamento($id_fatura)
{
    $faturaModel = new Fatura();
    $fatura = $faturaModel->buscarPorId($id_fatura);

    if (!$fatura) {
        echo "Fatura não encontrada";
        return;
    }

    require_once __DIR__ . '/../services/MercadoPagoService.php';

    $mp = new MercadoPagoService();

    $resposta = $mp->criarPagamento(
        $fatura['valor'],
        "Fatura Logify #" . $id_fatura
    );

    if (isset($resposta['init_point'])) {
        header("Location: " . $resposta['init_point']);
        exit;
    } else {
        echo "Erro ao gerar pagamento";
    }
}
}