<?php 


require_once '../app/Views/layouts/header.php'; 
?>

<h2>📊 Dashboard de Cliente</h2>
<p>Bem-vindo, **<?= htmlspecialchars($_SESSION['user_nome']) ?>**!</p>

<h3>Meus Pedidos Recentes</h3>
<?php if (empty($pedidos)): ?>
    <p>Você ainda não fez nenhum pedido.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID do Pedido</th>
                <th>Data</th>
                <th>Valor Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
            <tr>
                <td><?= $pedido['id'] ?></td>
                <td><?= date('d/m/Y', strtotime($pedido['data_pedido'])) ?></td>
                <td>R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?></td>
                <td><span class="status-<?= strtolower($pedido['status']) ?>"><?= $pedido['status'] ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once '../app/Views/layouts/footer.php'; ?>