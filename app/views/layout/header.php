<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logify - Sistema de Monitoramento</title>
    </head>
<body style="background-color: #0f172a; color: #f8fafc; font-family: Arial, sans-serif; margin: 0; padding: 0;">

    <?php 
    // ==========================================
    // MENU EXCLUSIVO DO ADMINISTRADOR
    // ==========================================
    if (isset($_SESSION['admin'])): 
    ?>
        <header style="background: #1e293b; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #ef4444;">
            <div style="font-weight: bold; font-size: 20px; color: #f8fafc;">
                Logify <span style="color: #ef4444;">Admin</span>
            </div>
            <nav>
                <ul style="display: flex; list-style: none; gap: 20px; margin: 0; padding: 0;">
                    <li><a href="/ProjetoLogify/public/?acao=admin_dashboard" style="color: #cbd5e1; text-decoration: none;">Dashboard</a></li>
                    <li><a href="/ProjetoLogify/public/?acao=usuarios" style="color: #cbd5e1; text-decoration: none;">Base de Usuários</a></li>
                    <li><a href="/ProjetoLogify/public/?acao=admin_faturas" style="color: #cbd5e1; text-decoration: none;">Aprovar Faturas</a></li>
                    <li><a href="/ProjetoLogify/public/?acao=logout" style="color: #ef4444; text-decoration: none; font-weight: bold;">Sair</a></li>
                </ul>
            </nav>
        </header>

    <?php 
    // ==========================================
    // MENU EXCLUSIVO DO USUÁRIO COMUM
    // ==========================================
    elseif (isset($_SESSION['usuario'])): 
    ?>
        <header style="background: #0f172a; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #334155;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <h2 style="margin: 0; color: #f8fafc;">Logify</h2>
                <span style="background: #38bdf8; color: black; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold;">
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
    <?php endif; ?>

    <div style="padding: 20px;">