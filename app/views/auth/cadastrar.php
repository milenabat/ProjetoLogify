<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Logify</title>
    </head>
<body>

    <div class="container-cadastro">
        <h2>Criar Nova Conta</h2>
        <p>Cadastre-se para monitorar seus projetos.</p>

        <form action="/ProjetoLogify/public/?acao=salvar_cadastro" method="POST">
            
            <div class="campo">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" required placeholder="Digite seu nome">
            </div>

            <div class="campo">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required placeholder="Digite seu e-mail">
            </div>

            <div class="campo">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required placeholder="Crie uma senha forte">
            </div>

            <button type="submit">Finalizar Cadastro</button>
        </form>

        <div class="voltar-login">
            <p>Já possui uma conta? <a href="/ProjetoLogify/public/?acao=login">Faça login</a></p>
        </div>
    </div>

</body>
</html>