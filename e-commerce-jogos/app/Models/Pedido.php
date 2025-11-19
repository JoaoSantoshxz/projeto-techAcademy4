<?php


class Pedido {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getConexao(); 
    }

  
    public function buscarPedidosPorCliente($cliente_id) {
        $sql = "SELECT id, data_pedido, valor_total, status FROM pedidos 
                WHERE cliente_id = ? 
                ORDER BY data_pedido DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$cliente_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function criarPedido($cliente_id, $valor_total, $itens_carrinho) {
        $this->pdo->beginTransaction();
        try {
           
            $sqlPedido = "INSERT INTO pedidos (cliente_id, valor_total) VALUES (?, ?)";
            $stmtPedido = $this->pdo->prepare($sqlPedido);
            $stmtPedido->execute([$cliente_id, $valor_total]);
            $pedido_id = $this->pdo->lastInsertId();

            $sqlItem = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario) VALUES (?, ?, ?, ?)";
            $sqlEstoque = "UPDATE produtos SET estoque = estoque - ? WHERE id = ?";
            
            foreach ($itens_carrinho as $item) {
            
                $stmtItem = $this->pdo->prepare($sqlItem);
                $stmtItem->execute([$pedido_id, $item['produto_id'], $item['quantidade'], $item['preco_unitario']]);

                $stmtEstoque = $this->pdo->prepare($sqlEstoque);
                $stmtEstoque->execute([$item['quantidade'], $item['produto_id']]);
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
          
            return false;
        }
    }
  
}