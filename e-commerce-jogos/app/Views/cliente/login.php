<?php 

require_once '../app/Views/layout/heater.php'; ?>

<h2> Login de Clientes </h2>

<?php if (isset($mensagem)): ?>
    <p class="mensagem-erro"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <form action="/cliente/autenticar" method="POST">
        <label for="email">Email:</label\>
        <input tyoe="email" id="email" name="email" required>

    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required>

    <button type="submit">Entrar</button>
</form>

<p>Ainda não tem conta? <a href="/cliente/cadastro">Cadastre-se aqui</a>.</p>

<?php require_once '../app/Views/layouts/footer.php'; ?>