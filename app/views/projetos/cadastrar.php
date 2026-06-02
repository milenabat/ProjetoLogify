<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="cabecalho-pagina" style="display: flex; justify-content: space-between; margin-bottom: 20px;">
    <h2>Cadastrar Novo Projeto</h2>
    <a href="/ProjetoLogify/public/?acao=projetos" class="btn" style="background: #334155; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">Voltar</a>
</div>

<div class="form-card" style="background: #1e293b; padding: 30px; border-radius: 8px; max-width: 500px;">
    <form action="/ProjetoLogify/public/?acao=salvar_projeto" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
        
        <div>
            <label style="color: #38bdf8; font-weight: bold; margin-bottom: 5px; display: block;">Nome do Projeto:</label>
            <input type="text" name="nome_projeto" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #334155; background: #0f172a; color: white;">
        </div>

        <div>
            <label style="color: #38bdf8; font-weight: bold; margin-bottom: 5px; display: block;">Dono do Projeto (Usuário):</label>
            <select name="id_usuario" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #334155; background: #0f172a; color: white;">
                <option value="">Selecione o usuário</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?php echo $usuario['id_usuario']; ?>">
                        <?php echo htmlspecialchars($usuario['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" style="background: #38bdf8; color: black; padding: 12px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; margin-top: 10px;">Salvar Projeto</button>
    </form>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>