<?php

class Cliente {
    private $pdo;

    public function __contruct() {
        $this->pdo = Conexao::getCOnexao();
    }

    public function cadrastar($nome, $email, $senha_hash) {
        $sql = "INSERT INTO clientes ($nome, $email, $swenha_hash) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $email, $senha_hash]);
    }

    public function buscarPorEmail($email) {
        $sql = "SELECT id, nome, email, senha_hash FROM clientes WHERE email = ? ";
        $srmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}