<?php

namespace Volg\Core;

class ConfigManager {

    private static array $config = [];

    public static function get(String $key = '', $file = 'config.ini'): mixed {
        self::loadConf($file);

        return isset(self::$config[$file][$key]) ? self::$config[$file][$key] : null;
    }

    public static function all($file = 'config.ini'): mixed {
        self::loadConf($file);

        return self::$config[$file];
    }

    public static function loadConf($file):void{
        if(!isset(self::$config[$file])){
            self::$config[$file] = parse_ini_file(BASE_PATH . "/Config/{$file}");
        }       
    }
}