<?php

require_once __DIR__ . '/../app/controllers/UsuarioController.php';
require_once __DIR__ . '/../app/controllers/ProjetoController.php';
require_once __DIR__ . '/../app/controllers/LogController.php';
require_once __DIR__ . '/../app/controllers/FaturaController.php';
require_once __DIR__ . '/../app/controllers/ApiLogController.php';
require_once __DIR__ . '/../app/controllers/PagamentoController.php';

$acao = $_GET['acao'] ?? 'inicio';

$controller = new UsuarioController();

if ($acao == 'usuarios') {
    $controller->listar();

} elseif ($acao == 'cadastrar_usuario') {
    $controller->abrirFormularioCadastro();

} elseif ($acao == 'salvar_usuario') {
    $controller->salvar();

} elseif ($acao == 'editar_usuario') {
    $controller->editar();

} elseif ($acao == 'atualizar_usuario') {
    $controller->atualizar();

} elseif ($acao == 'excluir_usuario') {
    $controller->excluir();

} elseif ($acao == 'projetos') {
    $projetoController = new ProjetoController();
    $projetoController->listar();

} elseif ($acao == 'cadastrar_projeto') {
    $projetoController = new ProjetoController();
    $projetoController->abrirFormularioCadastro();

} elseif ($acao == 'salvar_projeto') {
    $projetoController = new ProjetoController();
    $projetoController->salvar();

} elseif ($acao == 'editar_projeto') {
    $projetoController = new ProjetoController();
    $projetoController->editar();

} elseif ($acao == 'atualizar_projeto') {
    $projetoController = new ProjetoController();
    $projetoController->atualizar();

} elseif ($acao == 'excluir_projeto') {
    $projetoController = new ProjetoController();
    $projetoController->excluir();

} elseif ($acao == 'analisar_logs_projeto') {
    $projetoController = new ProjetoController();
    $projetoController->analisarLogs();

} elseif ($acao == 'logs') {
    $logController = new LogController();
    $logController->listar();

} elseif ($acao == 'cadastrar_log') {
    $logController = new LogController();
    $logController->abrirFormularioCadastro();

} elseif ($acao == 'salvar_log') {
    $logController = new LogController();
    $logController->salvar();

} elseif ($acao == 'editar_log') {
    $logController = new LogController();
    $logController->editar();

} elseif ($acao == 'atualizar_log') {
    $logController = new LogController();
    $logController->atualizar();

} elseif ($acao == 'excluir_log') {
    $logController = new LogController();
    $logController->excluir();

} elseif ($acao == 'api_receber_log') {
    $apiLogController = new ApiLogController();
    $apiLogController->receberLog();

} elseif ($acao == 'faturas') {
    $faturaController = new FaturaController();
    $faturaController->listar();

} elseif ($acao == 'cadastrar_fatura') {
    $faturaController = new FaturaController();
    $faturaController->abrirFormularioCadastro();

} elseif ($acao == 'salvar_fatura') {
    $faturaController = new FaturaController();
    $faturaController->salvar();

} elseif ($acao == 'editar_fatura') {
    $faturaController = new FaturaController();
    $faturaController->editar();

} elseif ($acao == 'atualizar_fatura') {
    $faturaController = new FaturaController();
    $faturaController->atualizar();

} elseif ($acao == 'excluir_fatura') {
    $faturaController = new FaturaController();
    $faturaController->excluir();

} elseif ($acao == 'pagar_fatura') {
    $faturaController = new FaturaController();
    $faturaController->pagar();

} elseif ($acao == 'webhook_pagamento') {
    $pagamentoController = new PagamentoController();
    $pagamentoController->webhook();

} 
elseif ($acao == 'gerar_pagamento') {
    $faturaController = new FaturaController();
    $faturaController->gerarPagamento($_GET['id']);
}
elseif ($acao == 'webhook_pagamento_mp') {
    $pagamentoController = new PagamentoController();
    $pagamentoController->webhookMP();
}elseif ($acao == 'gerar_pagamento') {
    $faturaController = new FaturaController();
    $faturaController->gerarPagamento($_GET['id']);
}
else {
    // Isso é o que faz a tela inicial puxar o seu home.php estilizado!
    require_once __DIR__ . '/../app/views/home.php'; 
}