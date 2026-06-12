<?php include __DIR__ . '/../layout/header.php'; ?>

<main class="container-admin" style="padding: 20px;">
    <div style="margin-bottom: 30px;">
        <h1 style="color: #f8fafc; margin-bottom: 5px;">Bem-vinda, <?php echo htmlspecialchars($_SESSION['admin']['nome'] ?? 'Admin'); ?>!</h1>
        <p style="color: #94a3b8; margin-top: 0;">Este é o seu centro de controle. O que você deseja gerenciar hoje?</p>
    </div>

    <div class="cards-resumo" style="display: flex; gap: 20px; flex-wrap: wrap;">
        
        <div class="card" style="background: #1e293b; padding: 25px; border-radius: 8px; flex: 1; min-width: 250px; border-top: 4px solid #38bdf8; box-shadow: 0 4px 6px rgba(0,0,0,0.3);">
            <h3 style="color: #f8fafc; margin-top: 0;">Gerenciar Usuários</h3>
            <p style="color: #cbd5e1; font-size: 14px; margin-bottom: 25px; line-height: 1.5;">Visualize a base de clientes cadastrados, exclua contas ou faça o upgrade manual de planos.</p>
            <a href="/ProjetoLogify/public/?acao=usuarios" style="background: #38bdf8; color: black; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block;">Acessar Usuários</a>
        </div>

        <div class="card" style="background: #1e293b; padding: 25px; border-radius: 8px; flex: 1; min-width: 250px; border-top: 4px solid #facc15; box-shadow: 0 4px 6px rgba(0,0,0,0.3);">
            <h3 style="color: #f8fafc; margin-top: 0;">Área Financeira</h3>
            <p style="color: #cbd5e1; font-size: 14px; margin-bottom: 25px; line-height: 1.5;">Verifique os comprovantes enviados pelos usuários e aprove a liberação de limites de logs.</p>
            <a href="/ProjetoLogify/public/?acao=admin_faturas" style="background: #facc15; color: black; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block;">Acessar Faturas</a>
        </div>

    </div>
</main>

<?php include __DIR__ . '/../layout/footer.php'; ?>