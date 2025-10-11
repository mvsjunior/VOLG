<?php

return [
    'db' => [
        'driver'   => 'Pdo',
        'dsn'      => 'mysql:dbname=volg_db;host=localhost;charset=utf8mb4',
        'username' => 'root',
        'password' => 'root',
        'driver_options' => [
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'
        ],
    ],
];
