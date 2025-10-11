<?php

use App\Models\UserRepository;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\AdapterInterface;
use Volg\Core\Http\Router;

return [
    'services' => [
        // outros serviços fixos
    ],
    'factories' => [
        AdapterInterface::class => function ($container) {
            $config = $container->get('config');
            if (!isset($config['db'])) {
                throw new \RuntimeException("Configuração de DB não encontrada");
            }
            $dbConfig = $config['db'];
            return new Adapter($dbConfig);
        },
        // exemplo de serviço que precisa de adapter
        UserRepository::class => function ($container) {
            return new UserRepository(
                $container->get(AdapterInterface::class)
            );
        },
        // exemplo de serviço que precisa de adapter
        Router::class => function ($container) {
            return new Router;
        },
    ],
];
