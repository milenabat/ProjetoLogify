<?php include __DIR__ . '/../layout/header.php'; ?>

<main class="container-user">
    <div style="margin-bottom: 30px;">
        <h1 style="color: #f8fafc; margin-bottom: 5px;">Meu Plano e Faturas</h1>
        <p style="color: #94a3b8; margin-top: 0;">Acompanhe o seu consumo de logs e envie comprovantes de pagamento.</p>
    </div>

    <div style="background: #1e293b; padding: 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #38bdf8;">
        <h3 style="color: #f8fafc; margin-top: 0;">Status da Assinatura</h3>
        <p style="color: #cbd5e1;">Seu plano atual é o <strong><?php echo htmlspecialchars($_SESSION['usuario']['plano'] ?? 'Free'); ?></strong>.</p>
        <?php if (($_SESSION['usuario']['plano'] ?? 'Free') === 'Free'): ?>
            <p style="color: #facc15; font-size: 14px;">Você está próximo do limite de logs? Realize o pagamento e envie o comprovante abaixo para o Administrador aprovar seu upgrade para o Premium.</p>
        <?php endif; ?>
    </div>

    <div class="tabela-card" style="background: #1e293b; padding: 20px; border-radius: 8px; overflow-x: auto;">
        <h2 style="color: #f8fafc; margin-top: 0; margin-bottom: 20px;">Histórico de Faturas</h2>
        
        <?php if (!empty($faturas)): ?>
            <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 12px 10px; color: #38bdf8; border-bottom: 1px solid #334155;">ID</th>
                        <th style="text-align: left; padding: 12px 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Data</th>
                        <th style="text-align: left; padding: 12px 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Valor</th>
                        <th style="text-align: left; padding: 12px 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Status</th>
                        <th style="text-align: left; padding: 12px 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($faturas as $fatura): ?>
                        <tr>
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155; color: #f8fafc;">#<?php echo $fatura['id_fatura']; ?></td>
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155; color: #f8fafc;"><?php echo date('d/m/Y', strtotime($fatura['data_geracao'])); ?></td>
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155; color: #f8fafc;">R$ <?php echo number_format($fatura['valor'], 2, ',', '.'); ?></td>
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155;">
                                <span style="background: #eab308; color: black; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold;">
                                    <?php echo htmlspecialchars($fatura['status']); ?>
                                </span>
                            </td>
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155;">
                                <a href="/ProjetoLogify/public/?acao=enviar_comprovante&id=<?php echo $fatura['id_fatura']; ?>" style="color: #38bdf8; text-decoration: none; font-weight: 500;">Enviar Comprovante</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color: #94a3b8; padding: 10px 0;">Nenhuma fatura pendente no momento.</p>
        <?php endif; ?>
    </div>
</main>

<?php include __DIR__ . '/../layout/footer.php'; ?>