<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador - Logify</title>
    </head>
<body>

    <header class="navbar-admin">
        <div class="logo">
            <h2>Logify Admin</h2>
        </div>
        <nav>
            <ul>
                <li><a href="/ProjetoLogify/public/?acao=admin_dashboard">Dashboard</a></li>
                <li><a href="/ProjetoLogify/public/?acao=usuarios">Base de Usuários</a></li>
                <li><a href="/ProjetoLogify/public/?acao=admin_faturas">Aprovar Faturas</a></li>
                <li><a href="/ProjetoLogify/public/?acao=logout" style="color: red;">Sair do Sistema</a></li>
            </ul>
        </nav>
    </header>

    <main class="container-admin">
        <h1>Bem-vinda, <?php echo $_SESSION['admin']['nome']; ?>!</h1>
        <p>Este é o seu centro de controle. O que você deseja gerenciar hoje?</p>

        <div class="cards-resumo">
            <div class="card">
                <h3>Gerenciar Usuários</h3>
                <p>Visualize e exclua clientes, ou faça o upgrade de planos.</p>
                <a href="/ProjetoLogify/public/?acao=usuarios" class="btn">Acessar Usuários</a>
            </div>

            <div class="card">
                <h3>Área Financeira</h3>
                <p>Verifique os comprovantes enviados e libere limites de logs.</p>
                <a href="/ProjetoLogify/public/?acao=admin_faturas" class="btn">Acessar Faturas</a>
            </div>
        </div>
    </main>

</body>
</html>