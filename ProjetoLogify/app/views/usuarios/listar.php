<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listar Usuários - Logify</title>
</head>
<body>
    <h1>Usuários do Logify</h1>

    <a href="/ProjetoLogify/public/">Voltar ao início</a> |
    <a href="/ProjetoLogify/public/?acao=cadastrar_usuario">Novo Usuário</a>

    <hr>

    <?php if (!empty($usuarios)): ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Plano</th>
                <th>Ações</th>
            </tr>

            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['id_usuario']; ?></td>
                    <td><?php echo $usuario['nome']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td><?php echo $usuario['plano']; ?></td>
                    <td>
                        <a href="/ProjetoLogify/public/?acao=editar_usuario&id=<?php echo $usuario['id_usuario']; ?>">Editar</a>
                    </td>
                </tr>

                <td>
    <a href="/ProjetoLogify/public/?acao=editar_usuario&id=<?php echo $usuario['id_usuario']; ?>">Editar</a> |
    <a href="/ProjetoLogify/public/?acao=excluir_usuario&id=<?php echo $usuario['id_usuario']; ?>" 
       onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
</td>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum usuário encontrado.</p>
    <?php endif; ?>
</body>
</html>