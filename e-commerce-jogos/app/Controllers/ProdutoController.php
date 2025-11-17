<?php

require_once '../app/Models/Produto.php';

class ProdutoController {
    public function index() {
        $produtoModel = new Produto();
        $produtos = $produtoModel->buscarTodos();

        require_once '../app/Views/produto/listar.php';
    }

    public function adicionarCarrinho() {
        if ($_SERVER['REQUEST_MOTHOD'] == 'POST') {
            $produto_id = $_POST['produto_id'];

            session_start();
            if (!sset($_SESSION['carrinho'])){
                $_SESSION['carrinho'] = [];
            }

            header('Locatin: /carrinho');
            exit;
        }
    }
}