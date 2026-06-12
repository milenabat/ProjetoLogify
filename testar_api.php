<?php
// testar_api.php

// 1. A URL da sua API
// Atenção: Se você salvou esse arquivo na raiz do projeto, a URL para chamar o index.php que está na pasta public fica assim:
$url = 'http://localhost/ProjetoLogify/public/?acao=api_receber_log';

// 2. Os dados do erro que aconteceram no sistema do cliente
$dados = [
    'nivel' => 'error',
    'mensagem' => 'Falha crítica: O banco de dados do sistema principal não respondeu.'
];

$json = json_encode($dados);

// 3. Configurando o envio simulando a internet
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

// 🔥 A CHAVE MÁGICA: É aqui que o cliente prova que o projeto é dele
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-API-KEY: logify_19815ae8584b40f6d72e0bc4fbcd0b8d' // <--- Substitua pela sua API Key real
]);

// 4. Dispara e mostra a resposta
$resposta = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<h3>Status Code: $httpcode</h3>";
echo "<p>Resposta da API: $resposta</p>";