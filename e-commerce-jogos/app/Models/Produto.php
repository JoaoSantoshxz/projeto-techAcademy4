<?php

class Produto {
    private $pdo;

        public function __construct() {
        $this->pdo = Conexao::getConexao();
    }

    

    public function listarTodos() {
    $sql = "SELECT id, nome, valor FROM produtos WHERE ativo = TRUE ORDER BY nome ASC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

        public function criar($nome, $valor, $estoque) {
    $sql = "INSERT INTO produtos ($nome, $valor, $estoque) VALUES (?, ?, ?)";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$nome, $valor, $estoque]);
    }

    //public function buscarTodos() {
    //$sql = "SELECT id, nome, valor, estoque FROM produtos ORDER BY nome";
    //$stmt = $this->pdo->query($sql);
    //return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //}

    public function atualizar($id, $nome, $valor, $estoque) {
    $sql = $this->pdo->prepare($sql);
    return $stmt->execute([$nome, $valor, $estoque, $id]);
    }

    public function deletar($id) {
    $slq = "DELETE FROM produtos WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$id]);
    }

}
