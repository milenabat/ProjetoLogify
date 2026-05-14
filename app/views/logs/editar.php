<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Log</title>
</head>
<body>
    <h1>Editar Log</h1>

    <form action="/ProjetoLogify/public/?acao=atualizar_log" method="POST">

        <input type="hidden" name="id_log" value="<?php echo $log['id_log']; ?>">

        <label>Mensagem:</label><br>
        <textarea name="mensagem" required><?php echo $log['mensagem']; ?></textarea><br><br>

        <label>Projeto:</label><br>
        <select name="id_projeto" required>
            <?php foreach ($projetos as $projeto): ?>
                <option value="<?php echo $projeto['id_projeto']; ?>"
                    <?php echo ($projeto['id_projeto'] == $log['id_projeto']) ? 'selected' : ''; ?>>
                    <?php echo $projeto['nome_projeto']; ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>

    <br>
    <a href="/ProjetoLogify/public/?acao=logs">Voltar</a>
</body>
</html>