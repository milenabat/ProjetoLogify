<?php include __DIR__ . '/../layout/header.php'; ?>

<main class="container-user" style="padding: 20px;">
    <div style="margin-bottom: 30px;">
        <h1 style="color: #f8fafc; margin-bottom: 5px;">Enviar Comprovante</h1>
        <p style="color: #94a3b8; margin-top: 0;">Anexe o comprovante de pagamento para liberação do seu plano.</p>
    </div>

    <div class="form-card" style="background: #1e293b; padding: 30px; border-radius: 8px; max-width: 500px; border-top: 4px solid #38bdf8;">
        <form action="/ProjetoLogify/public/?acao=salvar_comprovante" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 20px;">
            
            <input type="hidden" name="id_fatura" value="<?php echo htmlspecialchars($_GET['id'] ?? ''); ?>">

            <div>
                <label style="color: #cbd5e1; font-weight: bold; margin-bottom: 10px; display: block;">Anexar Arquivo (PDF, JPG, PNG):</label>
                <input type="file" name="comprovante" accept=".pdf, image/png, image/jpeg" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px dashed #38bdf8; background: #0f172a; color: white; cursor: pointer;">
            </div>

            <div style="display: flex; gap: 15px; margin-top: 10px;">
                <button type="submit" style="background: #38bdf8; color: black; padding: 12px 20px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; flex: 1;">Enviar para Análise</button>
                <a href="/ProjetoLogify/public/?acao=faturas" style="background: #334155; color: white; padding: 12px 20px; border-radius: 6px; text-decoration: none; text-align: center; font-weight: bold; flex: 1;">Voltar</a>
            </div>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../layout/footer.php'; ?>
2