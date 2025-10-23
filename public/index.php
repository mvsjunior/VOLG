<?php

require_once(__DIR__ . "/../Core/bootstrap.php");

/** Iniciando o motor de rotas */
$router = $container->get('Router');

// Carrega as rotas em arquivos diferentes
$numberOfFileRoutes = sizeof($router->routersDir);

if($numberOfFileRoutes){
    for($loopCounter = 0; $loopCounter < $numberOfFileRoutes; $loopCounter++){
        include_once(BASE_PATH . "/" . $router->routersDir[$loopCounter]);
    }
}

$router->dispatch();