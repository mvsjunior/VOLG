<?php

namespace Volg\Core\Http;

use Exception;
use Psr\Container\ContainerInterface;
use Volg\Core\ConfigManager;

class Router
{
    protected array $routes   = [];
    protected array $notFound = [];
    public array $routersDir = [];
    protected ?ContainerInterface $container = null;

    public function __construct(){
        
        $this->routersDir = parse_ini_file(BASE_PATH . "/Config/config.ini")['routes_dir'];
    }

    public function setContainer(ContainerInterface $container): void {
        $this->container = $container;
    }

    public function getContainer(): ?ContainerInterface
    {
        return $this->container;
    }

    public function get(string $uri = '', mixed $callable = [], $middleware = null)
    {
        if(is_array($callable)){
            $class  = isset($callable[0]) ? $callable[0] : '';
            $method = isset($callable[1]) ? $callable[1] : '';
            $callable = [$class, $method];
        }

        $this->routes[$uri]["GET"] = [
                "callable" => $callable,
                "middleware" => $middleware
        ];
    }

    public function post(string $uri = '', mixed $callable = [], $middleware = null)
    {
        if(is_array($callable)){
            $class  = isset($classAndMethod[0]) ? $classAndMethod[0] : '';
            $method = isset($classAndMethod[1]) ? $classAndMethod[1] : '';
            $callable = [$class, $method];
        }

        $this->routes[$uri]["POST"] = [
                "callable" => $callable,
                "middleware" => $middleware
        ];
    }

    public function dispatch()
    {
        $pathInfo       = isset($_SERVER["REQUEST_URI"]) ? filter_var($_SERVER["REQUEST_URI"], FILTER_SANITIZE_URL) : '/';
        $pathInfo       = strtok($pathInfo, '?'); // Remove a query string, se existir
        $requestMethod  = filter_var($_SERVER["REQUEST_METHOD"], FILTER_DEFAULT);
        $rotas          = $this->routes;

        // Verificando se a rota é apta a ser executada
        if(!isset($rotas[$pathInfo]))
        {
            throw new Exception("Rota não encontrada", 1);
            // echo "Rota não encontrada";
            die();
        }

        // Verifica se há um middleware
        if(!empty($rotas[$pathInfo][$requestMethod]['middleware']))
        {
            $middleware = $rotas[$pathInfo][$requestMethod]['middleware'];
            // Em caso de array, o middleware foi definido como classe
            if(is_array($middleware))
            {
                $middlewareClass  = isset($middleware[0]) ? $middleware[0] : '';

                if(!class_exists($middlewareClass))
                {
                    echo "Classe do middleware não definida";
                    die();
                }

                $middlewareMethod = isset($middleware[1]) ? $middleware[1] : '';

                if(!is_callable([new $middlewareClass, $middlewareMethod]))
                {
                    echo "O método da classe do middleware não é executável.";
                }

                call_user_func([new $middlewareClass,$middlewareMethod],[$this->container]);
            }else{
                if(!is_callable($rotas[$pathInfo][$requestMethod]['middleware']))
                {
                    echo "O método da classe do middleware não é executável.";
                }

                call_user_func($rotas[$pathInfo][$requestMethod]['middleware'], [$this->container]);
            }
        }
        // <<< Middleware


        /********************************************
         * Controller 
         * ******************************************
         */
        // Verifica se há uma classe/função executável

        if(is_array($rotas[$pathInfo][$requestMethod]["callable"])){
            $class  = isset($rotas[$pathInfo][$requestMethod]["callable"][0]) ? $rotas[$pathInfo][$requestMethod]["callable"][0] : '';
            if(!class_exists($class))
            {
                echo "Classe não existe";
                die();
            }
    
            $method = isset($rotas[$pathInfo][$requestMethod]["callable"][1]) ? $rotas[$pathInfo][$requestMethod]["callable"][1] : '';
    
            if(is_callable([new $class($this->container), $method]))
            {
                call_user_func([new $class($this->container), $method]);
            }
        }else{
            if(is_callable($rotas[$pathInfo][$requestMethod]["callable"])){
                call_user_func($rotas[$pathInfo][$requestMethod]["callable"]);
            }
        }
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function notFound()
    {
        
    }

    public function loadRoutersDirs(){
        $this->routersDir = ConfigManager::get('routes_dir') ?? [];
    }

    public function loadFileRouter($path = ''){
        include_once(BASE_PATH . "/" . $path);
    }
}