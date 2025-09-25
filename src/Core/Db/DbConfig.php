<?php

namespace Volg\Core\Db;

class DbConfig {

    public string $driver;
    public string $host;
    public string $dbName;
    public string $port;
    public string $user;
    public string $password;

    public function __construct(array $dbConf = []){
        $this->driver   = $dbConf["DRIVER"];
        $this->host     = $dbConf["HOST"];
        $this->dbName   = $dbConf["DB_NAME"];
        $this->port     = $dbConf["PORT"];
        $this->user     = $dbConf["USER"];
        $this->password = $dbConf["PASSWORD"];
    }
}