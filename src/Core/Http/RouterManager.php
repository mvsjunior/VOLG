<?php

namespace Volg\Core\Http;

use Volg\Core\Http\Router;

final class RouterManager{

    private static Router | null $instance = null;

    public static function getInstance(): Router {
        if(self::$instance == null){
            self::$instance = new Router();
        }

        return self::$instance;
    }
}