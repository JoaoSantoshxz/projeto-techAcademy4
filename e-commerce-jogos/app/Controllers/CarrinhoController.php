<?php

// ... dentro do CarrinhoController, antes de finalizar o pedido
$sql = "SELECT fn_verificar_estoque(:produto_id, :quantidade)";
$stmt = $this->pdo->prepare($sql);
$stmt->execute(['produto_id' => $id, 'quantidade' => $qtd]);
$disponivel = $stmt->fetchColumn();

if ($disponivel) {
    // Procede com a criação do pedido e baixa no estoque (Transaction)
} else {
    // Retorna erro de estoque
}