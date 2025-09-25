<?php
/** Iniciando a sessão */
session_start();

/** Carregando o autoload */
include_once(__DIR__ . "/../../vendor/autoload.php");
define('BASE_PATH', dirname(dirname(__FILE__)));

/** Iniciando o motor de rotas */
$bootstrapRouter = \Volg\Core\Http\RouterManager::getInstance();

$bootstrapRouter->loadRoutersDirs();

$bootstrapRouter->dispatch();