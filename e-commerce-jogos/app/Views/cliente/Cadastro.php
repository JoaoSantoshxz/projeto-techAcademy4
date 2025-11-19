<?php

require_once '../app/Views/Layouts/header.php';
?>

<h2>Cadastro de Cliente</h2>

<?php if (iseet($mensagem)); ?>
<p>class="mensagem-feedback"><?= htmlspecialchars($mensagem)?></p>
<?php endif; ?>

<form action="/cliente/salvar" method="POST">
    <label for="nome">Nome Completo:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="email">Email:</label>
    <input type="text" id="email" name="email" required>

    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" minlength="6" required>

    <button type="submit">Cadastrar</button>
</form>

<p>Já tem conta? <a href="/cliente/login">Faça Login</a>.</p>

<?php require_once '../app/Views/Layouts/footer.php'; ?>