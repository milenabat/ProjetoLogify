<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="cabecalho-pagina" style="display: flex; justify-content: space-between; margin-bottom: 20px;">
    <h2>Gerenciamento de Faturas</h2>
    <a href="/ProjetoLogify/public/?acao=cadastrar_fatura" class="btn">+ Nova Fatura</a>
</div>

<div class="tabela-card" style="background: #1e293b; padding: 20px; border-radius: 8px;">
    <?php if (!empty($faturas)): ?>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">ID</th>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Usuário</th>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Valor</th>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Status</th>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($faturas as $fatura): ?>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #334155;">#<?php echo $fatura['id_fatura']; ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #334155;"><?php echo htmlspecialchars($fatura['nome'] ?? ''); ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #334155;">R$ <?php echo number_format($fatura['valor'], 2, ',', '.'); ?></td>
                        
                        <td style="padding: 10px; border-bottom: 1px solid #334155;">
                            <?php if ($fatura['status'] == 'pago'): ?>
                                <span style="background: #059669; color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px;">Pago</span>
                            <?php else: ?>
                                <span style="background: #ea580c; color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px;">Pendente</span>
                            <?php endif; ?>
                        </td>

                        <td style="padding: 10px; border-bottom: 1px solid #334155;">
                            <a href="/ProjetoLogify/public/?acao=editar_fatura&id=<?php echo $fatura['id_fatura']; ?>" style="color: #facc15; margin-right: 10px; text-decoration: none;">Editar</a>
                            
                            <a href="/ProjetoLogify/public/?acao=excluir_fatura&id=<?php echo $fatura['id_fatura']; ?>" style="color: #ef4444; margin-right: 15px; text-decoration: none;" onclick="return confirm('Excluir esta fatura?')">Excluir</a>

                            <?php if ($fatura['status'] != 'pago'): ?>
                                <a href="/ProjetoLogify/public/?acao=gerar_pagamento&id=<?php echo $fatura['id_fatura']; ?>" style="background: #009ee3; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-weight: bold;">💳 Pagar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="color: #94a3b8;">Nenhuma fatura registrada no momento.</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>