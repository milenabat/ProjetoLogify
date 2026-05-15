<?php

require_once __DIR__ . '/../models/Log.php';
require_once __DIR__ . '/../models/Projeto.php';
require_once __DIR__ . '/../models/Usuario.php';

class ApiLogController
{
    public function receberLog()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $api_key = $_POST['api_key'] ?? null;
            $mensagem = $_POST['mensagem'] ?? null;

            if (empty($api_key) || empty($mensagem)) {
                echo "Erro: api_key e mensagem são obrigatórios.";
                return;
            }

            $projetoModel = new Projeto();
            $projeto = $projetoModel->buscarPorApiKey($api_key);

            if (!$projeto) {
                echo "Erro: API Key inválida ou projeto inativo.";
                return;
            }

            $id_projeto = $projeto['id_projeto'];
            $id_usuario = $projeto['id_usuario'];

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->buscarPorId($id_usuario);

            if (!$usuario) {
                echo "Erro: usuário responsável pelo projeto não encontrado.";
                return;
            }

            $logModel = new Log();

            $plano = strtolower($usuario['plano']);
            $limiteFree = 3;

            if ($plano == 'free') {
                $totalLogs = $logModel->contarLogsPorUsuario($id_usuario);

                if ($totalLogs >= $limiteFree) {
                    echo "Log bloqueado: limite do plano Free atingido. Faça upgrade para o plano Pro.";
                    return;
                }
            }

            $sucesso = $logModel->cadastrar($mensagem, $id_projeto);

            if ($sucesso) {
                echo "Log recebido e salvo com sucesso!";
            } else {
                echo "Erro ao salvar log.";
            }
        } else {
            echo "Essa rota aceita apenas requisições POST.";
        }
    }
}