<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="cabecalho-pagina" style="display: flex; justify-content: space-between; margin-bottom: 20px;">
    <h2>Editar Fatura #<?php echo $fatura['id_fatura']; ?></h2>
    <a href="/ProjetoLogify/public/?acao=faturas" class="btn" style="background: #334155; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">Voltar</a>
</div>

<div class="form-card" style="background: #1e293b; padding: 30px; border-radius: 8px; max-width: 500px;">
    <form action="/ProjetoLogify/public/?acao=atualizar_fatura" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
        <input type="hidden" name="id_fatura" value="<?php echo $fatura['id_fatura']; ?>">

        <div>
            <label style="color: #38bdf8; font-weight: bold; margin-bottom: 5px; display: block;">Cliente (Usuário):</label>
            <select name="id_usuario" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #334155; background: #0f172a; color: white;">
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?php echo $usuario['id_usuario']; ?>" <?php echo ($usuario['id_usuario'] == $fatura['id_usuario']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($usuario['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label style="color: #38bdf8; font-weight: bold; margin-bottom: 5px; display: block;">Valor Atual (R$):</label>
            <input type="number" name="valor" step="0.01" min="0" value="<?php echo $fatura['valor']; ?>" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #334155; background: #0f172a; color: white;">
        </div>

        <div>
            <label style="color: #38bdf8; font-weight: bold; margin-bottom: 5px; display: block;">Status:</label>
            <select name="status" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #334155; background: #0f172a; color: white;">
                <option value="pendente" <?php echo ($fatura['status'] == 'pendente') ? 'selected' : ''; ?>>Pendente</option>
                <option value="pago" <?php echo ($fatura['status'] == 'pago') ? 'selected' : ''; ?>>Pago</option>
            </select>
        </div>

        <button type="submit" style="background: #facc15; color: black; padding: 12px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; margin-top: 10px;">Salvar Alterações</button>
    </form>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>