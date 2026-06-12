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
$acao = $_GET['acao'] ?? 'login';

/* =========================
   AUTH E CADASTRO
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

// 🔥 Movemos o cadastro para cá! Antes que o PHP caia no 'else' lá do fundo
if ($acao === 'cadastrar_usuario') {
    (new AuthController())->cadastrar();
    exit;
}

if ($acao === 'salvar_cadastro') {
    (new AuthController())->salvarCadastro();
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
   GERENCIAMENTO DE USUÁRIOS
========================= */
if ($acao === 'usuarios') {
    (new UsuarioController())->listar();

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
   FATURAS E PAGAMENTOS
========================= */
} elseif ($acao === 'faturas') {
    (new FaturaController())->listar();

// 👇 As duas rotas novas agrupadas no lugar certo
} elseif ($acao === 'cadastrar_fatura') {
    (new FaturaController())->abrirFormularioCadastro();

} elseif ($acao === 'salvar_fatura') {
    (new FaturaController())->salvar();

} elseif ($acao === 'gerar_pagamento') {
    (new FaturaController())->gerarPagamento($_GET['id']);

} elseif ($acao === 'webhook_pagamento') {
    (new PagamentoController())->webhook();

} elseif ($acao === 'webhook_pagamento_mp') {
    (new PagamentoController())->webhookMP();
    } elseif ($acao === 'enviar_comprovante') {
    require_once __DIR__ . '/../app/views/faturas/enviar_comprovante.php';

} elseif ($acao === 'salvar_comprovante') {
    (new FaturaController())->salvarComprovante();

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
// O else absoluto, fechando a estrutura inteira!
} else {
    require_once __DIR__ . '/../app/views/home.php';
}