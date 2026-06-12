<?php

require_once __DIR__ . '/../models/Projeto.php';
require_once __DIR__ . '/../models/Log.php';

class ApiLogController
{
    public function receberLog()
    {
        // 1. Avisa para quem enviou a requisição que nós só respondemos em JSON
        header('Content-Type: application/json');

        // 2. Busca a API Key que o cliente enviou no cabeçalho da requisição
        $headers = apache_request_headers();
        $apiKey = $headers['X-API-KEY'] ?? null;

        if (!$apiKey) {
            http_response_code(401); // Erro de "Não Autorizado"
            echo json_encode(['erro' => 'API Key não informada no cabeçalho (X-API-KEY).']);
            return;
        }

        // 3. Vai no banco de dados verificar se essa API Key pertence a algum projeto ativo
        $projetoModel = new Projeto();
        $projeto = $projetoModel->buscarPorApiKey($apiKey);

        if (!$projeto) {
            http_response_code(401);
            echo json_encode(['erro' => 'API Key inválida ou projeto inativo.']);
            return;
        }

        // 4. Lê a "carta" que chegou com os detalhes do erro (o corpo da requisição)
        $jsonRecebido = file_get_contents('php://input');
        $dados = json_decode($jsonRecebido, true);

        // Se não mandou nada ou o JSON estiver quebrado, a gente barra
        if (!$dados || !isset($dados['mensagem'])) {
            http_response_code(400); // Erro de "Requisição Ruim"
            echo json_encode(['erro' => 'O corpo da requisição deve conter um JSON válido com a "mensagem" do erro.']);
            return;
        }

        // Extrai os dados do JSON (se não mandarem o nível, a gente assume que é "error" por padrão)
        $nivel = $dados['nivel'] ?? 'error';
        $mensagem = $dados['mensagem'];

        // 5. Salva a log no banco de dados, atrelando ao ID do projeto correto!
        $logModel = new Log();
        $sucesso = $logModel->cadastrar($projeto['id_projeto'], $nivel, $mensagem);

        if ($sucesso) {
            http_response_code(201); // Sucesso: "Criado"
            echo json_encode(['sucesso' => true, 'mensagem' => 'Log registrado com sucesso no Logify.']);
        } else {
            http_response_code(500); // Erro interno do nosso servidor
            echo json_encode(['erro' => 'Falha ao salvar a log no banco de dados.']);
        }
    }
}