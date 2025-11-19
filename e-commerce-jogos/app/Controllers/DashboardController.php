<?php
// /app/Controllers/DashboardController.php

require_once '../app/Models/Pedido.php';

class DashboardController {
    
    public function index() {
        session_start();
        // Verifica se o usuário tem acesso (Segurança)
        if (!isset($_SESSION['user_id'])) {
            header('Location: /cliente/login');
            exit;
        }

        $cliente_id = $_SESSION['user_id'];
        $pedidoModel = new Pedido();
        
        // Indicador 1: Lista de Pedidos
        $pedidos = $pedidoModel->buscarPedidosPorCliente($cliente_id);

        // Indicador 2: Faturamento total do cliente (Exemplo de consulta no Model)
        // $faturamento = $pedidoModel->calcularFaturamentoCliente($cliente_id); 
        
        require_once '../app/Views/dashboard/index.php'; 
    }
}