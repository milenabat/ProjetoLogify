<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="cabecalho-pagina" style="display: flex; justify-content: space-between; margin-bottom: 20px;">
    <h2>Gerenciamento de Projetos</h2>
    <a href="/ProjetoLogify/public/?acao=cadastrar_projeto" class="btn" style="background: #38bdf8; color: black; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold;">+ Novo Projeto</a>
</div>

<div class="tabela-card" style="background: #1e293b; padding: 20px; border-radius: 8px;">
    <?php if (!empty($projetos)): ?>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">ID</th>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Projeto</th>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Dono</th>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">API Key</th>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Status</th>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projetos as $projeto): ?>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #334155;">#<?php echo $projeto['id_projeto']; ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #334155;"><?php echo htmlspecialchars($projeto['nome_projeto']); ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #334155;"><?php echo htmlspecialchars($projeto['nome'] ?? 'Sem dono'); ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #334155;"><code style="background: #0f172a; padding: 4px; border-radius: 4px;"><?php echo htmlspecialchars($projeto['api_key']); ?></code></td>
                        <td style="padding: 10px; border-bottom: 1px solid #334155;">
                            <span style="background: #0284c7; color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px;"><?php echo htmlspecialchars($projeto['status']); ?></span>
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #334155;">
                            <a href="/ProjetoLogify/public/?acao=analisar_logs_projeto&id=<?php echo $projeto['id_projeto']; ?>" style="color: #38bdf8; margin-right: 10px; text-decoration: none;">Logs</a>
                            <a href="/ProjetoLogify/public/?acao=editar_projeto&id=<?php echo $projeto['id_projeto']; ?>" style="color: #facc15; margin-right: 10px; text-decoration: none;">Editar</a>
                            <a href="/ProjetoLogify/public/?acao=excluir_projeto&id=<?php echo $projeto['id_projeto']; ?>" style="color: #ef4444; text-decoration: none;" onclick="return confirm('Excluir este projeto?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="color: #94a3b8;">Nenhum projeto cadastrado.</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>