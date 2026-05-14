<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Fatura - Logify</title>
</head>
<body>
    <h1>Cadastrar Fatura</h1>

    <form action="/ProjetoLogify/public/?acao=salvar_fatura" method="POST">
        <label>Usuário:</label><br>
        <select name="id_usuario" required>
            <option value="">Selecione</option>
            <?php foreach ($usuarios as $usuario): ?>
                <option value="<?php echo $usuario['id_usuario']; ?>">
                    <?php echo $usuario['nome']; ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Valor:</label><br>
        <input type="number" name="valor" step="0.01" required><br><br>

        <label>Status:</label><br>
        <select name="status" required>
            <option value="">Selecione</option>
            <option value="pendente">Pendente</option>
            <option value="pago">Pago</option>
        </select><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <br>
    <a href="/ProjetoLogify/public/?acao=faturas">Voltar</a>
</body>
</html>