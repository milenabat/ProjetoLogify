<?php

require_once __DIR__ . '/../config/conexao.php';

echo "=== Cadastro de Usuário - Logify ===\n";

$nome = readline("Nome: ");
$email = readline("Email: ");
$senha = readline("Senha: ");
$plano = readline("Plano (Free/Pro): ");

$sql = "INSERT INTO usuarios (nome, email, senha, plano) VALUES (?, ?, ?, ?)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ssss", $nome, $email, $senha, $plano);

if ($stmt->execute()) {
    echo "\nUsuário cadastrado com sucesso!\n";
    echo "ID gerado: " . $conexao->insert_id . "\n";
} else {
    echo "\nErro ao cadastrar usuário: " . $stmt->error . "\n";
}