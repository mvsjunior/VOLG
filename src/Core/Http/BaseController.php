<?php

namespace Core\Http;

use Psr\Container\ContainerInterface;

class BaseController {

    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

}