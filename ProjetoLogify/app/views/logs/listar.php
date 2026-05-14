<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Logs de Erro - Logify</title>
</head>
<body>
    <h1>Logs de Erro</h1>

    <a href="/ProjetoLogify/public/">Voltar ao início</a>
<a href="/ProjetoLogify/public/?acao=cadastrar_log">Novo Log</a>

    <hr>

    <?php if (!empty($logs)): ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Mensagem</th>
                <th>Projeto</th>
                <th>Ações</th>
            </tr>

            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?php echo $log['id_log']; ?></td>
                    <td><?php echo $log['mensagem']; ?></td>
                    <td><?php echo $log['nome_projeto']; ?></td>
                
   <td>
                <a href="/ProjetoLogify/public/?acao=editar_log&id=<?php echo $log['id_log']; ?>">Editar</a> |
    <a href="/ProjetoLogify/public/?acao=excluir_log&id=<?php echo $log['id_log']; ?>"
       onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
</td>

                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum log encontrado.</p>
    <?php endif; ?>
</body>
</html>