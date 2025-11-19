<?php
// /app/Models/Pedido.php

class Pedido {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getConexao(); 
    }

    // CRUD - R (Read): Busca todos os pedidos do cliente para o Dashboard
    public function buscarPedidosPorCliente($cliente_id) {
        $sql = "SELECT id, data_pedido, valor_total, status FROM pedidos 
                WHERE cliente_id = ? 
                ORDER BY data_pedido DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$cliente_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // CRUD - C (Create): Inserção de um novo pedido (ocorre na finalização do carrinho)
    public function criarPedido($cliente_id, $valor_total, $itens_carrinho) {
        $this->pdo->beginTransaction();
        try {
            // 1. Insere na tabela 'pedidos'
            $sqlPedido = "INSERT INTO pedidos (cliente_id, valor_total) VALUES (?, ?)";
            $stmtPedido = $this->pdo->prepare($sqlPedido);
            $stmtPedido->execute([$cliente_id, $valor_total]);
            $pedido_id = $this->pdo->lastInsertId();

            // 2. Insere na tabela 'itens_pedido' e dá baixa no estoque
            $sqlItem = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario) VALUES (?, ?, ?, ?)";
            $sqlEstoque = "UPDATE produtos SET estoque = estoque - ? WHERE id = ?";
            
            foreach ($itens_carrinho as $item) {
                // Insere item
                $stmtItem = $this->pdo->prepare($sqlItem);
                $stmtItem->execute([$pedido_id, $item['produto_id'], $item['quantidade'], $item['preco_unitario']]);

                // Baixa no estoque (Função de disponibilidade deve ter sido chamada antes!)
                $stmtEstoque = $this->pdo->prepare($sqlEstoque);
                $stmtEstoque->execute([$item['quantidade'], $item['produto_id']]);
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            // Log do erro $e->getMessage()
            return false;
        }
    }
    // ... Aqui estaria o CRUD - U (Atualizar Status) e CRUD - D (Cancelar Pedido)
}