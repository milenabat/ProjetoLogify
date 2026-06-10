<?php

require_once __DIR__ . '/../models/Fatura.php';
require_once __DIR__ . '/../models/Usuario.php';

class PagamentoController
{
    /**
     * WEBHOOK DE TESTE (LOCAL)
     */
    public function webhook()
    {
        // 🔥 pega dados corretamente (GET ou POST)
        $id_fatura = $_POST['id_fatura'] ?? $_GET['id_fatura'] ?? null;
        $status_pagamento = $_POST['status_pagamento'] ?? $_GET['status_pagamento'] ?? null;

        // debug opcional (pode remover depois)
        // var_dump($id_fatura, $status_pagamento); exit;

        if (!$id_fatura || !$status_pagamento) {
            echo "Erro: id_fatura e status_pagamento são obrigatórios.";
            return;
        }

        if ($status_pagamento !== 'pago') {
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

        // atualiza status da fatura
        $faturaModel->marcarComoPago((int)$id_fatura);

        // atualiza plano do usuário
        $usuarioModel->atualizarPlano($fatura['id_usuario'], 'Pro');

        echo "Pagamento confirmado! Status atualizado para PAGO e usuário para PRO.";
    }

    /**
     * WEBHOOK REAL DO MERCADO PAGO
     */
    public function webhookMP()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        if (!$data) {
            echo "Dados inválidos do Mercado Pago.";
            return;
        }

        $status = $data['status'] ?? null;
        $id_fatura = $data['external_reference'] ?? null;

        if (!$status || !$id_fatura) {
            echo "Dados incompletos do Mercado Pago.";
            return;
        }

        if ($status !== 'approved') {
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

        // marca como pago
        $faturaModel->marcarComoPago((int)$id_fatura);

        // atualiza plano
        $usuarioModel->atualizarPlano($fatura['id_usuario'], 'Pro');

        echo "Pagamento processado com sucesso! Usuário atualizado para Pro.";
    }
}