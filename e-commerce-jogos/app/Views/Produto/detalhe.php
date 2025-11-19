<?php 
// /app/Views/produto/detalhe.php

// A variável $produto deve ser fornecida pelo ProdutoController::detalhe()

require_once '../app/Views/layouts/header.php'; 

if (empty($produto)):
?>
    <p>Produto não encontrado.</p>
<?php else: ?>
    <div class="detalhe-produto">
        <img src="/public/img/<?= htmlspecialchars($produto['id']) ?>.jpg" alt="<?= htmlspecialchars($produto['nome']) ?>">
        <div>
            <h2><?= htmlspecialchars($produto['nome']) ?></h2>
            <p class="preco-detalhe">Preço: **R$ <?= number_format($produto['valor'], 2, ',', '.') ?>**</p>
            <p>Descrição: <?= nl2br(htmlspecialchars($produto['descricao'] ?? 'Sem descrição detalhada.')) ?></p>
            <p class="estoque">Estoque Atual: **<?= $produto['estoque'] ?>** unidades</p>
            
            <form action="/carrinho/adicionar" method="POST">
                <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                <input type="number" name="quantidade" value="1" min="1" max="<?= $produto['estoque'] ?>" required style="width: 50px;">
                <button type="submit" <?= $produto['estoque'] <= 0 ? 'disabled' : '' ?>>
                    <?= $produto['estoque'] <= 0 ? 'Esgotado' : 'Comprar Agora' ?>
                </button>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php require_once '../app/Views/layouts/footer.php'; ?>