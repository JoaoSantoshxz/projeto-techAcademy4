<?php 

require_once '../app/Views/layouts/header.php'; 
?>

<h2>Jogos em Destaque</h2>

<div class="lista-produtos">
    <?php if (empty($produtos)): ?>
        <p>Nenhum produto encontrado no momento.</p>
    <?php else: ?>
        <?php foreach ($produtos as $produto): ?>
        <div class="produto-card">
            <img src="/public/img/<?= htmlspecialchars($produto['id']) ?>.jpg" alt="<?= htmlspecialchars($produto['nome']) ?>">
            <h3><?= htmlspecialchars($produto['nome']) ?></h3>
            <p class="preco">R$ <?= number_format($produto['valor'], 2, ',', '.') ?></p>
            
            <form action="/carrinho/adicionar" method="POST">
                <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                <input type="number" name="quantidade" value="1" min="1" max="<?= $produto['estoque'] ?>" required style="width: 50px;">
                <button type="submit" 
                        <?= $produto['estoque'] <= 0 ? 'disabled' : '' ?>>
                    <?= $produto['estoque'] <= 0 ? 'Esgotado' : 'Comprar' ?>
                </button>
            </form>
            <p class="estoque">Estoque: <?= $produto['estoque'] ?></p>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once '../app/Views/layouts/footer.php'; ?>