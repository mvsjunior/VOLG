<?php

namespace Volg\Core\Http;

use Volg\Core\Http\Router;
use Psr\Container\ContainerInterface;

final class RouterManager{

    private static Router | null $instance = null;
    protected ?ContainerInterface $container = null;


    public function setContainer(ContainerInterface $container): void {
        $this->container = $container;
    }

    public function getContainer(): ?ContainerInterface
    {
        return $this->container;
    }

    public static function getInstance(): Router {
        if(self::$instance == null){
            self::$instance = new Router();
        }

        return self::$instance;
    }
}