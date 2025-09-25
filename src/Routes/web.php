<?php

$webRouter = \Volg\Core\Http\RouterManager::getInstance();

$webRouter->get("/", function(){
    print_r(parse_ini_file(__DIR__ . "/../Config/config.ini"));
});