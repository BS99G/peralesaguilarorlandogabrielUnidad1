<?php
declare(strict_types=1);

class Database {
    private PDO $pdo;

    public function __construct() {
        $host = 'localhost';
        $db = 'nexusgaming';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            error_log('Error conexión BD: ' . $e->getMessage());
            exit('Error al conectar con la base de datos.');
        }
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }
}