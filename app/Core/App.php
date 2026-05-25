<?php
class App {
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();

        $controllerName = 'Home';
        if (isset($url[0]) && !empty($url[0])) {
            $controllerName = ucfirst($url[0]);
        }

        if (file_exists('../app/Controllers/' . $controllerName . 'Controller.php')) {
            $this->controller = $controllerName;
            if (isset($url[0])) unset($url[0]);
        }

        require_once '../app/Controllers/' . $this->controller . 'Controller.php';
        $controllerClass = $this->controller . 'Controller';
        $this->controller = new $controllerClass;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        if (!empty($url)) {
            $this->params = array_values($url);
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}
