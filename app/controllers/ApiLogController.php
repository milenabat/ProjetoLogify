<?php

require_once __DIR__ . '/../models/Log.php';
require_once __DIR__ . '/../models/Projeto.php';
require_once __DIR__ . '/../models/Usuario.php';

class ApiLogController
{
  public function receberLog()
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo "Método inválido";
        return;
    }

    $api_key = $_POST['api_key'] ?? null;
    $mensagem = $_POST['mensagem'] ?? null;

    if (!$api_key || !$mensagem) {
        echo "api_key e mensagem são obrigatórios";
        return;
    }

    $projetoModel = new Projeto();
    $usuarioModel = new Usuario();
    $logModel = new Log();

    // 1. validar API KEY
    $projeto = $projetoModel->buscarPorApiKey($api_key);

    if (!$projeto) {
        echo "API Key inválida";
        return;
    }

    // 2. pegar usuário dono do projeto
    $usuario = $usuarioModel->buscarPorId($projeto['id_usuario']);

    if (!$usuario) {
        echo "Usuário não encontrado";
        return;
    }

    // 3. contar logs do usuário
    $totalLogs = $logModel->contarLogsPorUsuario($usuario['id_usuario']);

    // 4. regra de negócio (AUTOMAÇÃO REAL)
    if ($usuario['plano'] == 'Free' && $totalLogs >= 5) {
        echo "Limite de logs atingido. Faça upgrade para Pro.";
        return;
    }

    // 5. salvar log automaticamente
    $sucesso = $logModel->cadastrar($mensagem, $projeto['id_projeto']);

    if ($sucesso) {
        echo "Log registrado com sucesso";
    } else {
        echo "Erro ao salvar log";
    }
}
}