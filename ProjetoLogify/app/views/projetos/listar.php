<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Projetos - Logify</title>
</head>
<body>
    <h1>Projetos do Logify</h1>

    <a href="/ProjetoLogify/public/">Voltar ao início</a> |
    <a href="/ProjetoLogify/public/?acao=cadastrar_projeto">Novo Projeto</a>

    <hr>

    <?php if (!empty($projetos)): ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Projeto</th>
                <th>Usuário</th>
                <th>Ações</th>
            </tr>

            <?php foreach ($projetos as $projeto): ?>
                <tr>
                    <td><?php echo $projeto['id_projeto']; ?></td>
                    <td><?php echo $projeto['nome_projeto']; ?></td>
                    <td><?php echo $projeto['nome']; ?></td>
                    <td>
                        <a href="/ProjetoLogify/public/?acao=editar_projeto&id=<?php echo $projeto['id_projeto']; ?>">Editar</a> |
                        <a href="/ProjetoLogify/public/?acao=excluir_projeto&id=<?php echo $projeto['id_projeto']; ?>"
                           onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum projeto encontrado.</p>
    <?php endif; ?>
</body>
</html>