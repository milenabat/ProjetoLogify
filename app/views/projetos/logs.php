<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Logs do Projeto - Logify</title>
</head>
<body>
    <h1>Logs do Projeto</h1>

    <a href="/ProjetoLogify/public/?acao=projetos">Voltar para projetos</a>

    <hr>

    <?php if (!empty($projeto)): ?>
        <h2><?php echo $projeto['nome_projeto']; ?></h2>

        <p><strong>ID do Projeto:</strong> <?php echo $projeto['id_projeto']; ?></p>
        <p><strong>API Key:</strong> <?php echo $projeto['api_key']; ?></p>
        <p><strong>Status:</strong> <?php echo $projeto['status']; ?></p>
    <?php else: ?>
        <p>Projeto não encontrado.</p>
    <?php endif; ?>

    <hr>

    <h2>Logs Recebidos</h2>

    <?php if (!empty($logs)): ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>ID do Log</th>
                <th>Mensagem</th>
            </tr>

            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?php echo $log['id_log']; ?></td>
                    <td><?php echo $log['mensagem']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum log encontrado para este projeto.</p>
    <?php endif; ?>
</body>
</html>