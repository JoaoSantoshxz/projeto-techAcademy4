<?php




require_once '../app/Models/Produto.php';
require_once '../app/Models/Pedido.php'; 
// Assumindo que Produto.php possui um método buscarPorId($id)

class CarrinhoController {

    // GET /carrinho (Visualiza o carrinho)
    public function index() {
        // O carrinho é um array armazenado na sessão
        session_start();
        $carrinho = $_SESSION['carrinho'] ?? [];
        require_once '../app/Views/carrinho/index.php'; // View para exibir o carrinho
    }

    // POST /carrinho/adicionar
    public function adicionar() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /');
            exit;
        }

        $produtoId = (int)$_POST['produto_id'];
        $quantidade = (int)$_POST['quantidade'];

        if ($quantidade <= 0) {
             // Redireciona com erro ou aviso
             header('Location: /carrinho');
             exit;
        }

        $produtoModel = new Produto();
        $produto = $produtoModel->buscarPorId($produtoId);

        if (!$produto || $produto['estoque'] < $quantidade) {
            // Lógica de erro: produto não existe ou estoque insuficiente
            $_SESSION['mensagem'] = "Estoque insuficiente para a quantidade solicitada.";
            header('Location: /carrinho');
            exit;
        }

        // Armazena no carrinho (Sessão)
        $_SESSION['carrinho'][$produtoId] = [
            'id' => $produtoId,
            'nome' => $produto['nome'],
            'valor_unitario' => $produto['valor'],
            'quantidade' => $quantidade,
        ];
        
        header('Location: /carrinho');
        exit;
    }
    
    // POST /carrinho/remover
    public function remover() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produto_id'])) {
            $produtoId = (int)$_POST['produto_id'];
            unset($_SESSION['carrinho'][$produtoId]);
        }
        header('Location: /carrinho');
        exit;
    }

    // POST /carrinho/finalizar
    public function finalizar() {
        session_start();
        
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['mensagem'] = "Você precisa estar logado para finalizar a compra.";
            header('Location: /cliente/login');
            exit;
        }

        $carrinho = $_SESSION['carrinho'] ?? [];
        if (empty($carrinho)) {
            header('Location: /carrinho');
            exit;
        }

        $clienteId = $_SESSION['user_id'];
        $valorTotal = 0;
        $itensParaPedido = [];
        
        // 1. Revalidação de Estoque e Cálculo Total (Função SQL fn_verificar_estoque deve ser usada aqui)
        $produtoModel = new Produto();
        $pedidoModel = new Pedido();

        foreach ($carrinho as $item) {
            // Revalida o estoque usando a função SQL para garantir atomicidade
            if (!$produtoModel->verificarDisponibilidade($item['id'], $item['quantidade'])) {
                $_SESSION['mensagem'] = "Estoque insuficiente para o produto: " . $item['nome'];
                header('Location: /carrinho');
                exit;
            }
            
            $valorTotal += ($item['valor_unitario'] * $item['quantidade']);
            $itensParaPedido[] = [
                'produto_id' => $item['id'],
                'quantidade' => $item['quantidade'],
                'preco_unitario' => $item['valor_unitario']
            ];
        }

        // 2. Criação do Pedido e Baixa no Estoque (Transação)
        if ($pedidoModel->criarPedido($clienteId, $valorTotal, $itensParaPedido)) {
            unset($_SESSION['carrinho']); // Limpa o carrinho
            $_SESSION['mensagem'] = "Pedido realizado com sucesso! ID: " . $pedidoModel->getLastInsertId();
            header('Location: /dashboard');
        } else {
            $_SESSION['mensagem'] = "Erro ao processar o pedido. Tente novamente.";
            header('Location: /carrinho');
        }
    }
}

$sql = "SELECT fn_verificar_estoque(:produto_id, :quantidade)";
$stmt = $this->pdo->prepare($sql);
$stmt->execute(['produto_id' => $id, 'quantidade' => $qtd]);
$disponivel = $stmt->fetchColumn();

if ($disponivel) {

} else {

}