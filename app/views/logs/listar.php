<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="cabecalho-pagina" style="display: flex; justify-content: space-between; margin-bottom: 20px;">
    <h2>Monitoramento de Logs</h2>
    <a href="/ProjetoLogify/public/?acao=cadastrar_log" class="btn" style="background: #38bdf8; color: black; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold;">+ Novo Log</a>
</div>

<div class="tabela-card" style="background: #1e293b; padding: 20px; border-radius: 8px;">
    <?php if (!empty($logs)): ?>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">ID</th>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Projeto Relacionado</th>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Mensagem do Log</th>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #334155;">#<?php echo $log['id_log']; ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #334155;">
                            <span style="background: #334155; color: white; padding: 4px 8px; border-radius: 4px; font-size: 13px;">
                                <?php echo htmlspecialchars($log['nome_projeto']); ?>
                            </span>
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #334155; color: #f87171; font-family: monospace;">
                            <?php echo htmlspecialchars($log['mensagem']); ?>
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #334155;">
                            <a href="/ProjetoLogify/public/?acao=editar_log&id=<?php echo $log['id_log']; ?>" style="color: #facc15; margin-right: 10px; text-decoration: none;">Editar</a>
                            <a href="/ProjetoLogify/public/?acao=excluir_log&id=<?php echo $log['id_log']; ?>" style="color: #ef4444; text-decoration: none;" onclick="return confirm('Excluir este log?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="color: #94a3b8;">Nenhum log registrado ainda.</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>