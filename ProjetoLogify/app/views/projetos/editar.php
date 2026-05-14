<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Projeto - Logify</title>
</head>
<body>
    <h1>Editar Projeto</h1>

    <form action="/ProjetoLogify/public/?acao=atualizar_projeto" method="POST">
        <input type="hidden" name="id_projeto" value="<?php echo $projeto['id_projeto']; ?>">

        <label>Nome do Projeto:</label><br>
        <input type="text" name="nome_projeto" value="<?php echo $projeto['nome_projeto']; ?>" required><br><br>

        <label>Usuário:</label><br>
        <select name="id_usuario" required>
            <option value="">Selecione</option>

            <?php foreach ($usuarios as $usuario): ?>
                <option value="<?php echo $usuario['id_usuario']; ?>"
                    <?php echo ($usuario['id_usuario'] == $projeto['id_usuario']) ? 'selected' : ''; ?>>
                    <?php echo $usuario['nome']; ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>

    <br>
    <a href="/ProjetoLogify/public/?acao=projetos">Voltar para a lista</a>
</body>
</html>