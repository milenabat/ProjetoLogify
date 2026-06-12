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
        // Tem que instanciar o UsuarioModel para buscar quem vai aparecer no <select>
        require_once __DIR__ . '/../models/Usuario.php';
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->listarTodos();

        // Agora sim a view recebe a variável $usuarios cheia de dados!
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
            }

            echo "Erro ao cadastrar fatura.";
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
                if ($status == 'pago') {
                    $usuarioModel->atualizarPlano($id_usuario, 'Pro');
                }

                header("Location: /ProjetoLogify/public/?acao=faturas");
                exit;
            }

            echo "Erro ao atualizar fatura.";
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
            }

            echo "Erro ao excluir fatura.";
        } else {
            echo "ID da fatura não informado.";
        }
    }

    public function gerarPagamento(int $id_fatura)
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

            "external_reference" => (string)$id_fatura,

            "back_urls" => [
                "success" => "http://localhost/ProjetoLogify/public/?acao=faturas",
                "failure" => "http://localhost/ProjetoLogify/public/?acao=faturas",
                "pending" => "http://localhost/ProjetoLogify/public/?acao=faturas"
            ]
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

        if (curl_errno($ch)) {
            echo "Erro CURL: " . curl_error($ch);
            curl_close($ch);
            return;
        }

        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['sandbox_init_point'])) {
            header("Location: " . $data['sandbox_init_point']);
            exit;
        }

        echo "<pre>";
        print_r($data);
        exit;
    }

    public function salvarComprovante()
    {
        $id_fatura = $_POST['id_fatura'] ?? null;
        $arquivo = $_FILES['comprovante'] ?? null;

        // DETETIVE 1: O ID da fatura chegou?
        if (!$id_fatura) {
            echo "<script>alert('Erro: O ID da fatura está vazio. Volte e clique novamente em Enviar Comprovante.'); window.history.back();</script>";
            return;
        }

        // DETETIVE 2: O arquivo chegou mesmo?
        if (!$arquivo || $arquivo['error'] !== UPLOAD_ERR_OK) {
            $codigoErro = $arquivo['error'] ?? 'Desconhecido';
            echo "<script>alert('Erro no envio da imagem. Código do erro PHP: " . $codigoErro . "\\n\\nDica: Verifique se a tag <form> no seu HTML possui o enctype=\"multipart/form-data\"'); window.history.back();</script>";
            return;
        }

        // Se passou pelos detetives, preparamos a pasta
        $diretorio_destino = __DIR__ . '/../../public/uploads/';
        if (!is_dir($diretorio_destino)) {
            mkdir($diretorio_destino, 0777, true);
        }

        $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
        $nome_novo = "fatura_" . $id_fatura . "_" . time() . "." . $extensao;
        $caminho_final = $diretorio_destino . $nome_novo;

        // DETETIVE 3: Conseguiu salvar na pasta?
        if (move_uploaded_file($arquivo['tmp_name'], $caminho_final)) {
            
            require_once __DIR__ . '/../models/Fatura.php';
            $faturaModel = new Fatura();
            $faturaModel->anexarComprovante($id_fatura, $nome_novo);

            echo "<script>alert('Comprovante enviado com sucesso! O Administrador irá analisar.'); window.location.href='/ProjetoLogify/public/?acao=faturas';</script>";
            return;
        } else {
            echo "<script>alert('Erro fatal: O PHP não teve permissão para salvar o arquivo na pasta uploads.'); window.history.back();</script>";
        }
    } // 🔥 ESTA CHAVE ESTAVA FALTANDO!

    public function gerarFaturaUpgrade()
    {
        $id_usuario = $_SESSION['usuario']['id_usuario'] ?? null;

        if ($id_usuario) {
            require_once __DIR__ . '/../models/Fatura.php';
            $faturaModel = new Fatura();
            
            // Cria uma fatura de R$ 49.90 para o plano Premium
            $id_nova_fatura = $faturaModel->cadastrar($id_usuario, 49.90, 'Pendente');

            if ($id_nova_fatura) {
                echo "<script>alert('Fatura gerada! Por favor, anexe o comprovante do PIX.'); window.location.href='/ProjetoLogify/public/?acao=enviar_comprovante&id=" . $id_nova_fatura . "';</script>";
                return;
            }
        }
        
        echo "<script>alert('Erro ao gerar fatura.'); window.history.back();</script>";
    }
}