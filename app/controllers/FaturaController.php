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
    $preference->back_urls = array(
    "success" => "http://localhost/ProjetoLogify/public/?acao=faturas",
    "failure" => "http://localhost/ProjetoLogify/public/?acao=faturas",
    "pending" => "http://localhost/ProjetoLogify/public/?acao=faturas"
);

$preference->auto_return = "approved";
}
public function salvarComprovante()
    {
        $id_fatura = $_POST['id_fatura'] ?? null;
        $arquivo = $_FILES['comprovante'] ?? null;

        if ($id_fatura && $arquivo && $arquivo['error'] === UPLOAD_ERR_OK) {
            // Cria a pasta de uploads se ela não existir
            $diretorio_destino = __DIR__ . '/../../public/uploads/';
            if (!is_dir($diretorio_destino)) {
                mkdir($diretorio_destino, 0777, true);
            }

            // Gera um nome único para o arquivo para não dar conflito
            $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
            $nome_novo = "fatura_" . $id_fatura . "_" . time() . "." . $extensao;
            $caminho_final = $diretorio_destino . $nome_novo;

            // Move o arquivo da memória temporária do PHP para a nossa pasta
            if (move_uploaded_file($arquivo['tmp_name'], $caminho_final)) {
                
                // Aqui você chamaria o seu FaturaModel para atualizar o status para 'Em Análise'
                // Exemplo: $faturaModel->atualizarStatus($id_fatura, 'Em Análise', $nome_novo);

                echo "<script>alert('Comprovante enviado com sucesso! O Administrador irá analisar.'); window.location.href='/ProjetoLogify/public/?acao=faturas';</script>";
                return;
            }
        }

        echo "<script>alert('Erro ao enviar o arquivo. Tente novamente.'); window.location.href='/ProjetoLogify/public/?acao=faturas';</script>";
    }

}