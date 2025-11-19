<?php

class Conexao {
    private static $pdo;

    private static $host = "local-host";
    private static $dbname = "game_store";
    private static $user = "root";
    private static $pass = "";

    public static function getConexao() {
        if (!isset(self::$pdo)) {
            try {
                $dns = "mysql:host=" . self::$host . ",;dbname=" . self::$dbname . ";charset=utf8";
                self::$pdo = new PDO($dsn, self::$user , self::$pass, [ 
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
            } catch (PDOException $e) {
                die("Erro de Conexão com o Banco de Dados: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}

require_once 'Conexao.php';