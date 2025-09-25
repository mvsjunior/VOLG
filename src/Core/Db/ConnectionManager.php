<?php

namespace Volg\Core\Db;

use PDO;
use Volg\Core\ConfigManager;

class ConnectionManager {

    static private Array $conn = [];
    const DEFAULT_DB = "db";

    public static function getConn($database = self::DEFAULT_DB): PDO{

        if(!isset(self::$conn[$database])){
            
            $dbConf = new DbConfig(ConfigManager::get($database));

            switch($dbConf->driver)
            {
                case "mysql":
                    self::$conn[$database] = new PDO("{$dbConf->driver}:host={$dbConf->host}:{$dbConf->port};dbname={$dbConf->dbName}",$dbConf->user, $dbConf->password);
                break;
                default:
                    self::$conn[$database] = new PDO("{$dbConf->driver}:host={$dbConf->host}:{$dbConf->port};dbname={$dbConf->dbName}",$dbConf->user, $dbConf->password);
            }
        }

        return self::$conn[$database];
    }
}