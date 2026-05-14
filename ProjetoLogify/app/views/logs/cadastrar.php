<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Log</title>
</head>
<body>
    <h1>Cadastrar Log de Erro</h1>

    <form action="/ProjetoLogify/public/?acao=salvar_log" method="POST">

        <label>Mensagem:</label><br>
        <textarea name="mensagem" required></textarea><br><br>

        <label>Projeto:</label><br>
        <select name="id_projeto" required>
            <option value="">Selecione</option>

            <?php foreach ($projetos as $projeto): ?>
                <option value="<?php echo $projeto['id_projeto']; ?>">
                    <?php echo $projeto['nome_projeto']; ?>
                </option>
            <?php endforeach; ?>

        </select><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <br>
    <a href="/ProjetoLogify/public/?acao=logs">Voltar</a>
</body>
</html>