<?php

use Volg\Core\Db\ConnectionManager;

$webRouter = \Volg\Core\Http\RouterManager::getInstance();

$webRouter->get("/", function(){
    
    $pdo = ConnectionManager::getConn();

    $sql  = "SELECT * FROM users;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchObject();

    echo '<pre>';
    print_r($result);

});