<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Store - E-commerce de Jogos</title>
    <link rel="stylesheet" href="/public/css/style.css"> 
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="/">Game Store</a></h1>
            <nav>
                <a href="/">Jogos</a>
                <a href="/carrinho">🛒 Carrinho</a>
                <?php 
                session_start(); 
                if (isset($_SESSION['user_id'])): 
                ?>
                    <a href="/dashboard">Olá, <?= htmlspecialchars($_SESSION['user_nome']) ?></a>
                    <a href="/cliente/logout">Sair</a>
                <?php else: ?>
                    <a href="/cliente/login">Login</a>
                    <a href="/cliente/cadastro">Cadastro</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="container">