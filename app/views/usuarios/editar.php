<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário - Logify</title>
</head>
<body>
    <h1>Editar Usuário</h1>

    <form action="/ProjetoLogify/public/?acao=atualizar_usuario" method="POST">
        <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">

        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?php echo $usuario['nome']; ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required><br><br>

        <label>Senha:</label><br>
        <input type="text" name="senha" value="<?php echo $usuario['senha']; ?>" required><br><br>

        <label>Plano:</label><br>
        <select name="plano" required>
            <option value="Free" <?php echo ($usuario['plano'] == 'Free') ? 'selected' : ''; ?>>Free</option>
            <option value="Pro" <?php echo ($usuario['plano'] == 'Pro') ? 'selected' : ''; ?>>Pro</option>
        </select><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>

    <br>
    <a href="/ProjetoLogify/public/?acao=usuarios">Voltar para a lista</a>
</body>
</html>