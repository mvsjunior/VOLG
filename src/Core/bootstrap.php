<?php
/** Iniciando a sessão */
session_start();

/** Carregando o autoload */
include_once(__DIR__ . "/../../vendor/autoload.php");
define('BASE_PATH', dirname(dirname(__FILE__)));

use DI\ContainerBuilder;

// === CONFIGURAÇÃO DO BANCO ===
$config = parse_ini_file(BASE_PATH . "/Config/config.ini");

// === CONSTRUÇÃO DO CONTAINER ===
$builder = new ContainerBuilder();

// Registrando dependências
$builder->addDefinitions(require_once(BASE_PATH . '/Config/container.php'));

$container = $builder->build();

/** Iniciando o motor de rotas */
$router = $container->get(\Volg\Core\Http\Router::class);
$router->setContainer($container);
// Carrega as rotas em arquivos diferentes
$numberOfFileRoutes = sizeof($router->routersDir);

if($numberOfFileRoutes){
    for($loopCounter = 0; $loopCounter < $numberOfFileRoutes; $loopCounter++){
        include_once(BASE_PATH . "/" . $router->routersDir[$loopCounter]);
    }
}

$router->dispatch();
