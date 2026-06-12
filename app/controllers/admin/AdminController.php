<?php
// app/controllers/admin/AdminController.php

require_once __DIR__ . '/../../core/AuthGuard.php';

class AdminController
{
    public function __construct()
    {
        // Protege TODAS as funções deste controller automaticamente
        AuthGuard::admin();
    }

    public function dashboard()
    {
        require_once __DIR__ . '/../../views/admin/dashboard.php';
    }

    public function faturas()
    {
        require_once __DIR__ . '/../../models/Fatura.php';
        $faturaModel = new Fatura();
        
        // Puxa todas as faturas para o Admin olhar
        $faturas = $faturaModel->listarTodasAdmin();
        
        require_once __DIR__ . '/../../views/admin/faturas.php';
    }

    public function comprovantes()
    {
        require_once __DIR__ . '/../../views/admin/comprovantes.php';
    }

 public function aprovarFatura()
    {
        echo "<div style='background: #0f172a; color: white; padding: 20px; font-family: sans-serif;'>";
        echo "<h3>Iniciando processo de aprovação...</h3>";
        
        $id_fatura = $_GET['id'] ?? null;
        $id_usuario = $_GET['id_usuario'] ?? null;
        echo "<p>✔️ 1. IDs capturados da URL: Fatura ($id_fatura) / Usuário ($id_usuario)</p>";

        if (!$id_fatura || !$id_usuario) {
            echo "<p style='color: red;'>❌ ERRO: Faltaram os IDs na URL!</p></div>";
            exit;
        }

        try {
            require_once __DIR__ . '/../../models/Fatura.php';
            echo "<p>✔️ 2. Model de Fatura carregado com sucesso.</p>";
            
            $faturaModel = new Fatura();
            $faturaModel->aprovar($id_fatura);
            echo "<p>✔️ 3. Status da fatura atualizado para Pago no banco.</p>";

            require_once __DIR__ . '/../../models/Usuario.php';
            echo "<p>✔️ 4. Model de Usuário carregado com sucesso.</p>";
            
            $usuarioModel = new Usuario();
            $usuarioModel->fazerUpgrade($id_usuario);
            echo "<p>✔️ 5. Cliente promovido para Premium no banco.</p>";

            echo "<h2 style='color: #22c55e;'>✔️ 6. SUCESSO TOTAL!</h2>";
            echo "<p>Se a tela parou aqui, os bancos foram atualizados. O problema era apenas o código de voltar de página.</p>";
            echo "<a href='/ProjetoLogify/public/?acao=admin_faturas' style='color: #38bdf8;'>Clique aqui para voltar manualmente</a>";
            
        } catch (Exception $e) {
            // Captura erros comuns
            echo "<h3 style='color: #ef4444;'>❌ ERRO ENCONTRADO: " . $e->getMessage() . "</h3>";
            echo "<p>Linha do erro: " . $e->getLine() . " no arquivo " . $e->getFile() . "</p>";
        } catch (Error $e) {
            // Captura erros fatais do PHP (como funções que não existem)
            echo "<h3 style='color: #ef4444;'>❌ ERRO FATAL: " . $e->getMessage() . "</h3>";
            echo "<p>Linha do erro: " . $e->getLine() . " no arquivo " . $e->getFile() . "</p>";
        }
        
        echo "</div>";
        exit;
    }}