<?php 




<h2>Jogos em Destaque</h2>

<?php 

if (isset($produtos) && !empty($produtos)): 
?>
    <div class="lista-produtos">
    <?php foreach ($produtos as $produto): ?>
        <div class="produto-card">
            <h3><?= htmlspecialchars($produto['nome']) ?></h3>
            <p>R$ <?= number_format($produto['valor'], 2, ',', '.') ?></p>
            <a href="/produto/detalhe/<?= $produto['id'] ?>">Ver Detalhes</a>
        </div>
    <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Nenhum produto encontrado no momento.</p>
<?php endif; ?>

