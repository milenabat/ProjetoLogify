<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Fatura - Logify</title>
</head>
<body>
    <h1>Editar Fatura</h1>

    <form action="/ProjetoLogify/public/?acao=atualizar_fatura" method="POST">
        <input type="hidden" name="id_fatura" value="<?php echo $fatura['id_fatura']; ?>">

        <label>Usuário:</label><br>
        <select name="id_usuario" required>
            <?php foreach ($usuarios as $usuario): ?>
                <option value="<?php echo $usuario['id_usuario']; ?>"
                    <?php echo ($usuario['id_usuario'] == $fatura['id_usuario']) ? 'selected' : ''; ?>>
                    <?php echo $usuario['nome']; ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Valor:</label><br>
        <input type="number" step="0.01" name="valor" value="<?php echo $fatura['valor']; ?>" required><br><br>

        <label>Status:</label><br>
        <select name="status" required>
            <option value="pendente" <?php echo ($fatura['status'] == 'pendente') ? 'selected' : ''; ?>>Pendente</option>
            <option value="pago" <?php echo ($fatura['status'] == 'pago') ? 'selected' : ''; ?>>Pago</option>
        </select><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>

    <br>
    <a href="/ProjetoLogify/public/?acao=faturas">Voltar</a>
</body>
</html>