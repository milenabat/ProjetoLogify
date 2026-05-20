<?php

require_once __DIR__ . '/../models/Fatura.php';
require_once __DIR__ . '/../models/Usuario.php';

class PagamentoController
{
    public function webhook()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo "Essa rota aceita apenas POST.";
            return;
        }

        $id_fatura = $_POST['id_fatura'] ?? null;
        $status_pagamento = $_POST['status_pagamento'] ?? null;

        if (!$id_fatura || !$status_pagamento) {
            echo "Erro: id_fatura e status_pagamento são obrigatórios.";
            return;
        }

        if ($status_pagamento != 'pago') {
            echo "Pagamento não aprovado.";
            return;
        }

        $faturaModel = new Fatura();
        $usuarioModel = new Usuario();

        $fatura = $faturaModel->buscarPorId((int)$id_fatura);

        if (!$fatura) {
            echo "Fatura não encontrada.";
            return;
        }

        $faturaModel->marcarComoPago($id_fatura);

        $usuarioModel->atualizarPlano($fatura['id_usuario'], 'Pro');

        echo "Pagamento confirmado! Usuário atualizado para Pro.";
    }

    public function webhookMP()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $status = $data['status'] ?? null;
        $id_fatura = $data['external_reference'] ?? null;

        if (!$status || !$id_fatura) {
            echo "Dados inválidos do Mercado Pago.";
            return;
        }

        // Mercado Pago usa "approved"
        if ($status != 'approved') {
            echo "Pagamento não aprovado.";
            return;
        }

        $faturaModel = new Fatura();
        $usuarioModel = new Usuario();

        $fatura = $faturaModel->buscarPorId((int)$id_fatura);

        if (!$fatura) {
            echo "Fatura não encontrada.";
            return;
        }

        $faturaModel->marcarComoPago($id_fatura);
        $usuarioModel->atualizarPlano($fatura['id_usuario'], 'Pro');

        echo "Pagamento processado com sucesso! Usuário atualizado para Pro.";
    }
}