<?php

class Conexao {
    private static $pdo;

    private static $host = "127.0.0.1"; 
    private static $mysql_port = "3306";
    private static $dbname = "loja_jogos";
    private static $user = "root";
    private static $pass = "";

    public static function getConexao() {
        if (!isset(self::$pdo)) {
            try {
                $dsn = "mysql:host=" . self::$host . ";port=" . self::$mysql_port . ";dbname=" . self::$dbname . ";charset=utf8";
                self::$pdo = new PDO($dsn, self::$user , self::$pass, [ 
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
            } catch (PDOException $e) {
                die("Erro de Conexão com o Banco de Dados: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}

require_once 'Conexao.php';