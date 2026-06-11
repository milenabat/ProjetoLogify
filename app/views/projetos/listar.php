<?php include __DIR__ . '/../layout/header.php'; ?>

<header class="navbar-user" style="display: flex; justify-content: space-between; align-items: center; background: #0f172a; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px;">
    <div class="logo" style="display: flex; align-items: center; gap: 10px;">
        <h2 style="margin: 0; color: #f8fafc;">Logify</h2>
        <span class="badge-plano" style="background: #38bdf8; color: black; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold;">
            <?php echo htmlspecialchars($_SESSION['usuario']['plano'] ?? 'Free'); ?>
        </span>
    </div>
    <nav>
        <ul style="display: flex; list-style: none; gap: 20px; margin: 0; padding: 0;">
            <li><a href="/ProjetoLogify/public/?acao=projetos" style="color: #38bdf8; text-decoration: none; font-weight: bold;">Meus Projetos</a></li>
            <li><a href="/ProjetoLogify/public/?acao=logs" style="color: #cbd5e1; text-decoration: none;">Monitoramento</a></li>
            <li><a href="/ProjetoLogify/public/?acao=faturas" style="color: #cbd5e1; text-decoration: none;">Financeiro</a></li>
            <li><a href="/ProjetoLogify/public/?acao=logout" style="color: #ef4444; text-decoration: none; font-weight: bold;">Sair</a></li>
        </ul>
    </nav>
</header>

<main class="container-user">
    <div style="margin-bottom: 30px;">
        <h1 style="color: #f8fafc; margin-bottom: 5px;">Olá, <?php echo htmlspecialchars($_SESSION['usuario']['nome'] ?? 'Usuário'); ?>!</h1>
        <p style="color: #94a3b8; margin-top: 0;">Aqui estão os seus projetos monitorados.</p>
    </div>

    <div class="cabecalho-pagina" style="display: flex; justify-content: space-between; margin-bottom: 20px; align-items: center;">
        <h2 style="color: #f8fafc; margin: 0;">Gerenciamento de Projetos</h2>
        <a href="/ProjetoLogify/public/?acao=cadastrar_projeto" class="btn" style="background: #38bdf8; color: black; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold;">+ Novo Projeto</a>
    </div>

    <div class="tabela-card" style="background: #1e293b; padding: 20px; border-radius: 8px; overflow-x: auto;">
        <?php if (!empty($projetos)): ?>
            <table style="width: 100%; border-collapse: collapse; min-width: 700px;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 12px 10px; color: #38bdf8; border-bottom: 1px solid #334155;">ID</th>
                        <th style="text-align: left; padding: 12px 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Projeto</th>
                        <th style="text-align: left; padding: 12px 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Dono</th>
                        <th style="text-align: left; padding: 12px 10px; color: #38bdf8; border-bottom: 1px solid #334155;">API Key</th>
                        <th style="text-align: left; padding: 12px 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Status</th>
                        <th style="text-align: left; padding: 12px 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projetos as $projeto): ?>
                        <tr>
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155; color: #f8fafc;">#<?php echo $projeto['id_projeto']; ?></td>
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155; color: #f8fafc;"><?php echo htmlspecialchars($projeto['nome_projeto']); ?></td>
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155; color: #f8fafc;"><?php echo htmlspecialchars($projeto['nome'] ?? 'Sem dono'); ?></td>
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155;">
                                <code style="background: #0f172a; color: #38bdf8; padding: 6px 8px; border-radius: 4px; font-family: monospace; font-size: 13px;">
                                    <?php echo htmlspecialchars($projeto['api_key']); ?>
                                </code>
                            </td>
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155;">
                                <span style="background: #0284c7; color: white; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold;">
                                    <?php echo htmlspecialchars($projeto['status']); ?>
                                </span>
                            </td>
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155;">
                                <a href="/ProjetoLogify/public/?acao=analisar_logs_projeto&id=<?php echo $projeto['id_projeto']; ?>" style="color: #38bdf8; margin-right: 12px; text-decoration: none; font-weight: 500;">Logs</a>
                                <a href="/ProjetoLogify/public/?acao=editar_projeto&id=<?php echo $projeto['id_projeto']; ?>" style="color: #facc15; margin-right: 12px; text-decoration: none; font-weight: 500;">Editar</a>
                                <a href="/ProjetoLogify/public/?acao=excluir_projeto&id=<?php echo $projeto['id_projeto']; ?>" style="color: #ef4444; text-decoration: none; font-weight: 500;" onclick="return confirm('Excluir este projeto?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color: #94a3b8; padding: 20px 0;">Nenhum projeto cadastrado ainda. Clique em "+ Novo Projeto" para começar.</p>
        <?php endif; ?>
    </div>
</main>

<?php include __DIR__ . '/../layout/footer.php'; ?>