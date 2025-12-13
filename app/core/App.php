<?php

class App
{
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        // AUTH GUARD
        if (!isset($_SESSION['auth_user']) || $_SESSION['auth_user'] !== true) {

            // Allow access to 'authenticate' method to process the form
            $is_authenticating = (isset($url[0]) && strtolower($url[0]) === 'auth' && isset($url[1]) && strtolower($url[1]) === 'authenticate');

            if (!$is_authenticating) {
                // Force controller to AuthController and method to login
                $this->controller = 'AuthController';
                $this->method = 'login';

                require_once __DIR__ . '/../controllers/AuthController.php';
                $this->controller = new AuthController;
                call_user_func_array([$this->controller, $this->method], []);
                return; // Stop execution of normal routing
            }
        }

        // Standard Routing
        if (isset($url[0])) {
            if (file_exists(__DIR__ . '/../controllers/' . ucfirst($url[0]) . 'Controller.php')) {
                $this->controller = ucfirst($url[0]) . 'Controller';
                unset($url[0]);
            }
        }

        require_once __DIR__ . '/../controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
