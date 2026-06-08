<?php
namespace Core;

class App {
    protected $controller = 'dashboard';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        if (isset($_GET['url'])) {
            $url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));
            $this->controller = isset($url[0]) && $url[0] !== '' ? strtolower($url[0]) : $this->controller;
            $this->method = isset($url[1]) && $url[1] !== '' ? strtolower($url[1]) : $this->method;

            unset($url[0], $url[1]);
            $this->params = array_values($url);
        }

        $this->loadController();
    }

    private function loadController() {
        $controller_name = 'App\\Controllers\\' . ucfirst($this->controller) . 'Controller';

        if (!class_exists($controller_name)) {
            $controller_name = 'App\\Controllers\\DashboardController';
        }

        if (class_exists($controller_name)) {
            $controller = new $controller_name();

            if (method_exists($controller, $this->method)) {
                call_user_func_array([$controller, $this->method], $this->params);
            } else {
                echo 'Method not found';
            }
        } else {
            echo 'Controller not found';
        }
    }
}
?>