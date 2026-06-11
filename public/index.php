<?php
session_start();

/* =========================
   CONTROLLERS
========================= */
require_once __DIR__ . '/../app/controllers/UsuarioController.php';
require_once __DIR__ . '/../app/controllers/ProjetoController.php';
require_once __DIR__ . '/../app/controllers/LogController.php';
require_once __DIR__ . '/../app/controllers/FaturaController.php';
require_once __DIR__ . '/../app/controllers/ApiLogController.php';
require_once __DIR__ . '/../app/controllers/PagamentoController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

/* =========================
   ROTA PADRÃO CORRETA
========================= */
$acao = $_GET['acao'] ?? 'home';

/* =========================
   AUTH
========================= */
if ($acao === 'login') {
    (new AuthController())->login();
    exit;
}

if ($acao === 'autenticar') {
    (new AuthController())->autenticar();
    exit;
}

if ($acao === 'logout') {
    (new AuthController())->logout();
    exit;
}

/* =========================
   ADMIN (SEPARADO)
========================= */
if ($acao === 'admin_dashboard') {
    require_once __DIR__ . '/../app/controllers/admin/AdminController.php';
    (new AdminController())->dashboard();
    exit;
}

if ($acao === 'admin_faturas') {
    require_once __DIR__ . '/../app/controllers/admin/AdminController.php';
    (new AdminController())->faturas();
    exit;
}

if ($acao === 'admin_comprovantes') {
    require_once __DIR__ . '/../app/controllers/admin/AdminController.php';
    (new AdminController())->comprovantes();
    exit;
}

/* =========================
   USUÁRIO
========================= */
if ($acao === 'usuarios') {
    (new UsuarioController())->listar();

} elseif ($acao === 'cadastrar_usuario') {
    (new UsuarioController())->abrirFormularioCadastro();

} elseif ($acao === 'salvar_usuario') {
    (new UsuarioController())->salvar();

} elseif ($acao === 'editar_usuario') {
    (new UsuarioController())->editar();

} elseif ($acao === 'atualizar_usuario') {
    (new UsuarioController())->atualizar();

} elseif ($acao === 'excluir_usuario') {
    (new UsuarioController())->excluir();

/* =========================
   PROJETOS
========================= */
} elseif ($acao === 'projetos') {
    (new ProjetoController())->listar();

} elseif ($acao === 'cadastrar_projeto') {
    (new ProjetoController())->abrirFormularioCadastro();

} elseif ($acao === 'salvar_projeto') {
    (new ProjetoController())->salvar();

} elseif ($acao === 'editar_projeto') {
    (new ProjetoController())->editar();

} elseif ($acao === 'atualizar_projeto') {
    (new ProjetoController())->atualizar();

} elseif ($acao === 'excluir_projeto') {
    (new ProjetoController())->excluir();

/* =========================
   LOGS
========================= */
} elseif ($acao === 'logs') {
    (new LogController())->listar();

} elseif ($acao === 'cadastrar_log') {
    (new LogController())->abrirFormularioCadastro();

} elseif ($acao === 'salvar_log') {
    (new LogController())->salvar();

/* =========================
   FATURAS
========================= */
} elseif ($acao === 'faturas') {
    (new FaturaController())->listar();

} elseif ($acao === 'gerar_pagamento') {
    (new FaturaController())->gerarPagamento($_GET['id']);

} elseif ($acao === 'webhook_pagamento') {
    (new PagamentoController())->webhook();

} elseif ($acao === 'webhook_pagamento_mp') {
    (new PagamentoController())->webhookMP();

/* =========================
   API LOGS
========================= */
} elseif ($acao === 'api_receber_log') {
    (new ApiLogController())->receberLog();

/* =========================
   HOME (ÚNICA ENTRADA VISUAL)
========================= */
} elseif ($acao === 'home') {
    require_once __DIR__ . '/../app/views/home.php';

/* =========================
   DEFAULT SE DER ERRO
========================= */
} else {
    require_once __DIR__ . '/../app/views/home.php';
}