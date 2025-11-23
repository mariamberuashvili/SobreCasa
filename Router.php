<?php
namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn) {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn) {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas() {
        $currentUrl = $_SERVER['REQUEST_URI'] ?? '/';
        $base = '/SobreCasa-mvc/public';
        $currentUrl = strtok($currentUrl, '?'); 
        if (str_starts_with($currentUrl, $base)) {
            $currentUrl = substr($currentUrl, strlen($base));
        }
        if ($currentUrl === '') $currentUrl = '/';

        $method = $_SERVER["REQUEST_METHOD"];
        $fn = $method === "GET" ? $this->getRoutes[$currentUrl] ?? null : $this->postRoutes[$currentUrl] ?? null;

        if ($fn) {
            call_user_func($fn, $this);
        } else {
            echo "Página No Existe";
        }
    }

public function render($view, $datos = []) {
       
        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        
        ob_start();
        include __DIR__ . "/./views/$view.php"; 
        $contenido = ob_get_clean(); 

        
        include __DIR__ . "/views/layout.php";
}


}
