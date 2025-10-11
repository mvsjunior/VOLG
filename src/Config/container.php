<?php

use App\Models\UserRepository;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\AdapterInterface;
use Volg\Core\Http\Router;
use Volg\Core\Http\RouterManager;

return [
    'config' => $config,

    AdapterInterface::class => function ($c) {
        $cfg = $c->get('config')['db'];
        return new Adapter($cfg);
    },

    Router::class => function ($c) {
        $router = new Router();
        $router->setContainer($c);
        return $router;
    },

    UserRepository::class => function ($c) {
        return new UserRepository($c->get(AdapterInterface::class));
    },
];