<?php

require_once '../app/Models/Cliente.php';

class ClienteController {
    
    public function cadastro() {
       
        session_start();
        $mensagem = $_SESSION['mensagem'] ?? null; 
        unset($_SESSION['mensagem']); 
        require_once '../app/Views/cliente/cadastro.php'; 
    }

    public function salvar() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /cliente/cadastro');
            exit;
        }

        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];
        

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $clienteModel = new Cliente();
        
    
        if ($clienteModel->buscarPorEmail($email)) {
            $_SESSION['mensagem'] = "Este e-mail já está cadastrado.";
            header('Location: /cliente/cadastro');
            exit;
        }

        if ($clienteModel->cadastrar($nome, $email, $senha_hash)) {
            $_SESSION['mensagem'] = "Cadastro realizado com sucesso! Faça seu login.";
            header('Location: /cliente/login');
        } else {
            $_SESSION['mensagem'] = "Erro ao cadastrar. Tente novamente.";
            header('Location: /cliente/cadastro');
        }
        exit;
    }
    
    
    public function login() {
        session_start();
        $mensagem = $_SESSION['mensagem'] ?? null;
        unset($_SESSION['mensagem']);
        require_once '../app/Views/cliente/login.php';
    }

   
    public function autenticar() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /cliente/login');
            exit;
        }

        $email = trim($_POST['email']);
        $senha = $_POST['senha'];

        $clienteModel = new Cliente();
        $cliente = $clienteModel->buscarPorEmail($email);

   
        if ($cliente && password_verify($senha, $cliente['senha_hash'])) {
            
            $_SESSION['user_id'] = $cliente['id'];
            $_SESSION['user_nome'] = $cliente['nome'];
            
            header('Location: /dashboard'); 
        } else {
          
            $_SESSION['mensagem'] = "E-mail ou senha inválidos.";
            header('Location: /cliente/login');
        }
        exit;
    }
    
  
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /'); 
        exit;
    }
}