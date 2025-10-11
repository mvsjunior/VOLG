<?php

$apiRouter = \Volg\Core\Http\RouterManager::getInstance();

$apiRouter->get('/api', function() use ($container){
    header('content-type: application/json');
    echo '{"value": "API Home"}';
});