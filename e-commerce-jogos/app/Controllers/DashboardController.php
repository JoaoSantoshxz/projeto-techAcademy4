<?php


require_once '../app/Models/Pedido.php';

class DashboardController {
    
    public function index() {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /cliente/login');
            exit;
        }

        $cliente_id = $_SESSION['user_id'];
        $pedidoModel = new Pedido();
        
        $pedidos = $pedidoModel->buscarPedidosPorCliente($cliente_id);

        
        require_once '../app/Views/dashboard/index.php'; 
    }
}