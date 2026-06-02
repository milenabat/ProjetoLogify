<?php include __DIR__ . '/layout/header.php'; ?>

<div class="dashboard-body" style="padding: 10px 20px;">
    
    <div class="cabecalho-pagina" style="margin-bottom: 40px;">
        <h2 style="color: #38bdf8; font-size: 28px; margin-bottom: 5px;">Visão Geral do Sistema</h2>
        <p style="color: #94a3b8;">Acompanhe as métricas de integração, logs e faturamento do seu painel.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 50px;">

        <div style="background: #1e293b; padding: 25px; border-radius: 10px; border-left: 4px solid #38bdf8; box-shadow: 0 4px 6px rgba(0,0,0,0.2);">
            <h4 style="color: #94a3b8; margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Projetos Ativos</h4>
            <p style="font-size: 36px; font-weight: bold; color: white; margin: 0;">12</p>
        </div>

        <div style="background: #1e293b; padding: 25px; border-radius: 10px; border-left: 4px solid #059669; box-shadow: 0 4px 6px rgba(0,0,0,0.2);">
            <h4 style="color: #94a3b8; margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Logs de Erro</h4>
            <p style="font-size: 36px; font-weight: bold; color: white; margin: 0;">1.043</p>
        </div>

        <div style="background: #1e293b; padding: 25px; border-radius: 10px; border-left: 4px solid #facc15; box-shadow: 0 4px 6px rgba(0,0,0,0.2);">
            <h4 style="color: #94a3b8; margin-bottom: 10px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Faturas Pendentes</h4>
            <p style="font-size: 36px; font-weight: bold; color: white; margin: 0;">4</p>
        </div>

    </div>

    <div style="background: #0f172a; padding: 30px; border-radius: 10px; border: 1px solid #334155;">
        <h3 style="color: #e2e8f0; margin-bottom: 20px; border-bottom: 1px solid #1e293b; padding-bottom: 15px;">Acesso Rápido</h3>
        
        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
            <a href="/ProjetoLogify/public/?acao=projetos" style="background: #334155; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold;">Gerenciar Projetos</a>
            <a href="/ProjetoLogify/public/?acao=logs" style="background: #334155; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold;">Monitorar Logs</a>
            <a href="/ProjetoLogify/public/?acao=usuarios" style="background: #334155; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold;">Base de Usuários</a>
            <a href="/ProjetoLogify/public/?acao=faturas" style="background: #009ee3; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold;">Área Financeira 💳</a>
        </div>
    </div>

</div>

<?php include __DIR__ . '/layout/footer.php'; ?>