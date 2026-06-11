<?php
// criar_admin.php

// Puxa a sua conexão com o banco
require_once __DIR__ . '/app/config/conexao.php';

// Coloque os dados do seu administrador principal aqui
$nome = 'Milena Admin';
$email = 'admin@logify.com';
$senha = 'SenhaForte123'; 
$tipo = 'admin';
$plano = 'Admin'; // Admins não precisam de plano, mas a coluna existe

// Criptografa a senha para o banco aceitar
$senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nome, email, senha, plano, tipo) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("sssss", $nome, $email, $senha_criptografada, $plano, $tipo);

if ($stmt->execute()) {
    echo "<h1>Sucesso!</h1><p>Administrador criado. Agora você já pode fazer login!</p>";
} else {
    echo "<h1>Erro</h1><p>Não foi possível criar o administrador.</p>";
}