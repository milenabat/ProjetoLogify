<?php include __DIR__ . '/../layout/header.php'; ?>

<main class="container-admin" style="padding: 20px;">
    <div style="margin-bottom: 30px;">
        <h1 style="color: #f8fafc; margin-bottom: 5px;">Aprovação de Faturas</h1>
        <p style="color: #94a3b8; margin-top: 0;">Verifique os comprovantes enviados e libere o plano Premium dos clientes.</p>
    </div>

    <div class="tabela-card" style="background: #1e293b; padding: 20px; border-radius: 8px; overflow-x: auto; border-top: 4px solid #facc15;">
        <?php if (!empty($faturas)): ?>
            <table style="width: 100%; border-collapse: collapse; min-width: 700px;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 12px 10px; color: #facc15; border-bottom: 1px solid #334155;">ID Fatura</th>
                        <th style="text-align: left; padding: 12px 10px; color: #facc15; border-bottom: 1px solid #334155;">Cliente</th>
                        <th style="text-align: left; padding: 12px 10px; color: #facc15; border-bottom: 1px solid #334155;">Valor</th>
                        <th style="text-align: left; padding: 12px 10px; color: #facc15; border-bottom: 1px solid #334155;">Status</th>
                        <th style="text-align: left; padding: 12px 10px; color: #facc15; border-bottom: 1px solid #334155;">Comprovante</th>
                        <th style="text-align: left; padding: 12px 10px; color: #facc15; border-bottom: 1px solid #334155;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($faturas as $fatura): ?>
                        <tr>
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155; color: #f8fafc;">#<?php echo $fatura['id_fatura']; ?></td>
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155; color: #f8fafc;"><?php echo htmlspecialchars($fatura['nome_cliente'] ?? 'Desconhecido'); ?></td>
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155; color: #f8fafc;">R$ <?php echo number_format($fatura['valor'], 2, ',', '.'); ?></td>
                            
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155;">
                                <?php if($fatura['status'] === 'Em Análise'): ?>
                                    <span style="background: #eab308; color: black; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold;">Em Análise</span>
                                <?php elseif($fatura['status'] === 'Pago'): ?>
                                    <span style="background: #22c55e; color: white; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold;">Pago</span>
                                <?php else: ?>
                                    <span style="background: #64748b; color: white; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold;"><?php echo htmlspecialchars($fatura['status']); ?></span>
                                <?php endif; ?>
                            </td>

                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155;">
                                <?php if(!empty($fatura['arquivo_comprovante'])): ?>
                                    <a href="/ProjetoLogify/public/uploads/<?php echo htmlspecialchars($fatura['arquivo_comprovante']); ?>" target="_blank" style="color: #38bdf8; text-decoration: none;">Ver Anexo</a>
                                <?php else: ?>
                                    <span style="color: #64748b;">Sem anexo</span>
                                <?php endif; ?>
                            </td>

                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155;">
                                <?php if($fatura['status'] !== 'Pago'): ?>
                                    <a href="/ProjetoLogify/public/?acao=aprovar_fatura_admin&id=<?php echo $fatura['id_fatura']; ?>&id_usuario=<?php echo $fatura['id_usuario']; ?>" style="background: #22c55e; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 13px;">Aprovar</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color: #94a3b8; padding: 20px 0;">Nenhuma fatura registrada no sistema no momento.</p>
        <?php endif; ?>
    </div>
</main>

<?php include __DIR__ . '/../layout/footer.php'; ?>