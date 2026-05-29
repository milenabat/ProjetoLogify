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

                // se já nascer como pago
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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id_fatura = $_POST['id_fatura'];
            $id_usuario = $_POST['id_usuario'];
            $valor = $_POST['valor'];
            $status = $_POST['status'];

            $faturaModel = new Fatura();
            $usuarioModel = new Usuario();

            $sucesso = $faturaModel->atualizar($id_fatura, $id_usuario, $valor, $status);

            if ($sucesso) {

                // REGRA AUTOMÁTICA
                if ($status == 'pago') {
                    $usuarioModel->atualizarPlano($id_usuario, 'Pro');
                }

                header("Location: /ProjetoLogify/public/?acao=faturas");
                exit;

            } else {
                echo "Erro ao atualizar fatura.";
            }
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

            $faturaModel->marcarComoPago($id_fatura);
            $usuarioModel->atualizarPlano($fatura['id_usuario'], 'Pro');

            header("Location: /ProjetoLogify/public/?acao=faturas");
            exit;

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

        $preference = [
            "items" => [
                [
                    "title" => "Plano Pro Logify",
                    "quantity" => 1,
                    "unit_price" => (float)$fatura['valor']
                ]
            ],
            "external_reference" => $id_fatura,
            "back_urls" => [
                "success" => "http://localhost/ProjetoLogify/public/?acao=faturas",
                "failure" => "http://localhost/ProjetoLogify/public/?acao=faturas",
                "pending" => "http://localhost/ProjetoLogify/public/?acao=faturas"
            ],
            "auto_return" => "approved"
        ];

        $config = require __DIR__ . '/../config/mercadopago.php';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/checkout/preferences");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $config['access_token'],
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($preference));

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['init_point'])) {
            header("Location: " . $data['init_point']);
            exit;
        } else {
            echo "Erro ao gerar pagamento";
        }
    }
}