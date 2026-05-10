<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Usuário - Logify</title>
</head>
<body>
    <h1>Cadastrar Usuário</h1>

    <form action="/ProjetoLogify/public/?acao=salvar_usuario" method="POST">
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Senha:</label><br>
        <input type="text" name="senha" required><br><br>

        <label>Plano:</label><br>
        <select name="plano" required>
            <option value="">Selecione</option>
            <option value="Free">Free</option>
            <option value="Pro">Pro</option>
        </select><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <br>
    <a href="/ProjetoLogify/public/?acao=usuarios">Voltar para a lista</a>
</body>
</html>