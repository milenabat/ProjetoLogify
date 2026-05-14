<?php

require_once __DIR__ . '/../models/Log.php';

class ApiLogController
{
    public function receberLog()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_projeto = $_POST['id_projeto'] ?? null;
            $mensagem = $_POST['mensagem'] ?? null;

            if (empty($id_projeto) || empty($mensagem)) {
                echo "Erro: id_projeto e mensagem são obrigatórios.";
                return;
            }

            $logModel = new Log();
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