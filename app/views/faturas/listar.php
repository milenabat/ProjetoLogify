<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Faturas - Logify</title>
</head>
<body>
    <h1>Faturas do Logify</h1>

    <a href="/ProjetoLogify/public/">Voltar ao início</a> |
    <a href="/ProjetoLogify/public/?acao=cadastrar_fatura">Nova Fatura</a>

    <hr>

    <?php if (!empty($faturas)): ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Usuário</th>
                <th>Valor</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>

            <?php foreach ($faturas as $fatura): ?>
                <tr>
                    <td><?php echo $fatura['id_fatura']; ?></td>
                    <td><?php echo $fatura['nome']; ?></td>
                    <td>R$ <?php echo $fatura['valor']; ?></td>
                    <td><?php echo $fatura['status']; ?></td>
                    <td>
    <a href="/ProjetoLogify/public/?acao=editar_fatura&id=<?php echo $fatura['id_fatura']; ?>">Editar</a> |
    <a href="/ProjetoLogify/public/?acao=excluir_fatura&id=<?php echo $fatura['id_fatura']; ?>"
       onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
</td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhuma fatura encontrada.</p>
    <?php endif; ?>
</body>
</html>