<?php
namespace Config;

use PDO;

class Database {
    private $host = 'localhost';
    private $db_name = 'exam_system';
    private $user = 'root';
    private $password = '';
    private $pdo;

    public function connect() {
        $this->pdo = null;

        try {
            $this->pdo = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->user,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die('Database Connection Error: ' . $e->getMessage());
        }

        return $this->pdo;
    }
}
?>