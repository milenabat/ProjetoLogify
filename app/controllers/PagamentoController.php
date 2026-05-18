<?php

require_once __DIR__ . '/../models/Fatura.php';
require_once __DIR__ . '/../models/Usuario.php';

class PagamentoController
{
    public function webhook()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo "Essa rota aceita apenas requisições POST.";
            return;
        }

        $id_fatura = $_POST['id_fatura'] ?? null;
        $status_pagamento = $_POST['status_pagamento'] ?? null;

        if (empty($id_fatura) || empty($status_pagamento)) {
            echo "Erro: id_fatura e status_pagamento são obrigatórios.";
            return;
        }

        if ($status_pagamento != 'pago') {
            echo "Pagamento ainda não aprovado. Nenhuma alteração realizada.";
            return;
        }

        $faturaModel = new Fatura();
        $usuarioModel = new Usuario();

        $fatura = $faturaModel->buscarPorId($id_fatura);

        if (!$fatura) {
            echo "Erro: fatura não encontrada.";
            return;
        }

        $sucessoFatura = $faturaModel->marcarComoPago($id_fatura);

        if (!$sucessoFatura) {
            echo "Erro ao atualizar status da fatura.";
            return;
        }

        $id_usuario = $fatura['id_usuario'];
        $sucessoUsuario = $usuarioModel->atualizarPlano($id_usuario, 'Pro');

        if ($sucessoUsuario) {
            echo "Pagamento confirmado! Fatura marcada como paga e usuário atualizado para Pro.";
        } else {
            echo "Fatura paga, mas houve erro ao atualizar o usuário para Pro.";
        }
    }
}