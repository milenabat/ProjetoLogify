<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="cabecalho-pagina" style="display: flex; justify-content: space-between; margin-bottom: 20px;">
    <h2>Gerenciamento de Usuários</h2>
    <a href="/ProjetoLogify/public/?acao=cadastrar_usuario" class="btn" style="background: #38bdf8; color: black; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold;">+ Novo Usuário</a>
</div>

<div class="tabela-card" style="background: #1e293b; padding: 20px; border-radius: 8px;">
    <?php if (!empty($usuarios)): ?>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">ID</th>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Nome</th>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Email</th>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Plano</th>
                    <th style="text-align: left; padding: 10px; color: #38bdf8; border-bottom: 1px solid #334155;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #334155;">#<?php echo $usuario['id_usuario']; ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #334155;"><?php echo htmlspecialchars($usuario['nome']); ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #334155;"><?php echo htmlspecialchars($usuario['email']); ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #334155;">
                            <span style="background: <?php echo ($usuario['plano'] == 'Pro') ? '#059669' : '#64748b'; ?>; color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px;">
                                <?php echo htmlspecialchars($usuario['plano']); ?>
                            </span>
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #334155;">
                            <a href="/ProjetoLogify/public/?acao=editar_usuario&id=<?php echo $usuario['id_usuario']; ?>" style="color: #facc15; margin-right: 10px; text-decoration: none;">Editar</a>
                            <a href="/ProjetoLogify/public/?acao=excluir_usuario&id=<?php echo $usuario['id_usuario']; ?>" style="color: #ef4444; text-decoration: none;" onclick="return confirm('Excluir este usuário?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="color: #94a3b8;">Nenhum usuário cadastrado.</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>