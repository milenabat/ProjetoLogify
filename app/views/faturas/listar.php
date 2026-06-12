<?php include __DIR__ . '/../layout/header.php'; ?>

<main class="container-user" style="padding: 20px;">
    <div style="margin-bottom: 30px;">
        <h1 style="color: #f8fafc; margin-bottom: 5px;">Meu Plano e Faturas</h1>
        <p style="color: #94a3b8; margin-top: 0;">Acompanhe o seu consumo de logs e gerencie seus pagamentos.</p>
    </div>

    <div class="form-card" style="background: #1e293b; padding: 20px; border-radius: 8px; border-left: 4px solid #38bdf8; margin-bottom: 30px;">
        <h3 style="color: white; margin-top: 0;">Status da Assinatura</h3>
        <p style="color: #cbd5e1;">Seu plano atual é o <strong><?php echo htmlspecialchars($_SESSION['usuario']['plano'] ?? 'Free'); ?></strong>.</p>
        
        <?php if (($_SESSION['usuario']['plano'] ?? 'Free') === 'Free'): ?>
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-top: 15px; flex-wrap: wrap; background: #0f172a; padding: 15px; border-radius: 8px;">
                <p style="color: #facc15; font-size: 14px; margin: 0; flex: 1; min-width: 250px;">
                    Você está próximo do limite de logs? Gere sua fatura e escolha pagar via Mercado Pago ou enviando um comprovante.
                </p>
                <a href="/ProjetoLogify/public/?acao=gerar_fatura_upgrade" style="background: #22c55e; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; white-space: nowrap;">
                    Gerar Fatura (R$ 49,90)
                </a>
            </div>
        <?php endif; ?>
    </div>

    <h2 style="color: white; margin-bottom: 15px;">Histórico de Faturas</h2>
    <div class="tabela-card" style="background: #1e293b; padding: 20px; border-radius: 8px; overflow-x: auto;">
        <?php if (!empty($faturas)): ?>
            <table style="width: 100%; border-collapse: collapse; min-width: 700px;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 12px 10px; color: #38bdf8; border-bottom: 1px solid #334155;">ID</th>
                        <th style="text-align: left; padding: 12px 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Data</th>
                        <th style="text-align: left; padding: 12px 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Valor</th>
                        <th style="text-align: left; padding: 12px 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Status</th>
                        <th style="text-align: left; padding: 12px 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Ações de Pagamento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($faturas as $fatura): ?>
                        <tr>
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155; color: #f8fafc;">#<?php echo $fatura['id_fatura']; ?></td>
                            
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155; color: #f8fafc;">
                                <?php 
                                    $data = $fatura['data_criacao'] ?? $fatura['data_geracao'] ?? null;
                                    echo $data ? date('d/m/Y', strtotime($data)) : 'N/D'; 
                                ?>
                            </td>
                            
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155; color: #f8fafc;">R$ <?php echo number_format($fatura['valor'], 2, ',', '.'); ?></td>
                            
                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155;">
                                <?php if($fatura['status'] === 'Em Análise'): ?>
                                    <span style="background: #eab308; color: black; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold;">Em Análise</span>
                                <?php elseif(strtolower($fatura['status']) === 'pago'): ?>
                                    <span style="background: #22c55e; color: white; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold;">Pago</span>
                                <?php else: ?>
                                    <span style="background: #64748b; color: white; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold;"><?php echo htmlspecialchars($fatura['status']); ?></span>
                                <?php endif; ?>
                            </td>

                            <td style="padding: 12px 10px; border-bottom: 1px solid #334155;">
                                <div style="display: flex; gap: 10px;">
                                    <?php if(strtolower($fatura['status']) !== 'pago' && $fatura['status'] !== 'Em Análise'): ?>
                                        
                                        <a href="/ProjetoLogify/public/?acao=gerar_pagamento&id=<?php echo $fatura['id_fatura']; ?>" style="background: #009ee3; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: bold; text-align: center;">Mercado Pago</a>
                                        
                                        <a href="/ProjetoLogify/public/?acao=enviar_comprovante&id=<?php echo $fatura['id_fatura']; ?>" style="background: #38bdf8; color: black; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: bold; text-align: center;">Anexar Comprovante</a>
                                        
                                    <?php elseif($fatura['status'] === 'Em Análise'): ?>
                                        <span style="color: #94a3b8; font-size: 13px;">Aguardando aprovação do Admin...</span>
                                    <?php else: ?>
                                        <span style="color: #22c55e; font-size: 13px; font-weight: bold;">Finalizado</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color: #94a3b8; padding: 10px 0;">Você não possui faturas geradas no momento.</p>
        <?php endif; ?>
    </div>
</main>

<?php include __DIR__ . '/../layout/footer.php'; ?>