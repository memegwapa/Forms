<?php
namespace Core;

class Controller {
    protected $db;

    public function __construct() {
        $database = new \Config\Database();
        $this->db = $database->connect();
    }

    protected function view($view, $data = []) {
        extract($data);
        $view_path = __DIR__ . '/../app/views/' . $view . '.php';
        
        if (file_exists($view_path)) {
            require $view_path;
        } else {
            echo 'View not found: ' . $view;
        }
    }

    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    protected function redirectIfNotLoggedIn() {
        if (!$this->isLoggedIn()) {
            header('Location: ' . APP_URL . 'auth/login');
            exit();
        }
    }

    protected function redirectIfLoggedIn() {
        if ($this->isLoggedIn()) {
            if ($_SESSION['role'] == 'admin') {
                header('Location: ' . APP_URL . 'admin/dashboard');
            } else {
                header('Location: ' . APP_URL . 'student/dashboard');
            }
            exit();
        }
    }
}
?>