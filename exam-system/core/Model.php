<?php
namespace Core;

class Model {
    protected $db;
    protected $table;

    public function __construct($db = null) {
        if ($db) {
            $this->db = $db;
        } else {
            $database = new \Config\Database();
            $this->db = $database->connect();
        }
    }

    protected function query($sql, $params = []) {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (\PDOException $e) {
            die('Query Error: ' . $e->getMessage());
        }
    }

    protected function fetchAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll(\PDO::FETCH_ASSOC);
    }

    protected function fetch($sql, $params = []) {
        return $this->query($sql, $params)->fetch(\PDO::FETCH_ASSOC);
    }

    protected function execute($sql, $params = []) {
        return $this->query($sql, $params);
    }
}
?>