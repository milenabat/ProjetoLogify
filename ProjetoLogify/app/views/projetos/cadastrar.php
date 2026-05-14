<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Projeto</title>
</head>
<body>
    <h1>Cadastrar Projeto</h1>

    <form action="/ProjetoLogify/public/?acao=salvar_projeto" method="POST">

        <label>Nome do Projeto:</label><br>
        <input type="text" name="nome_projeto" required><br><br>

        <label>Usuário:</label><br>
        <select name="id_usuario" required>
            <option value="">Selecione</option>

            <?php foreach ($usuarios as $usuario): ?>
                <option value="<?php echo $usuario['id_usuario']; ?>">
                    <?php echo $usuario['nome']; ?>
                </option>
            <?php endforeach; ?>

        </select><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <br>
    <a href="/ProjetoLogify/public/?acao=projetos">Voltar</a>
</body>
</html>