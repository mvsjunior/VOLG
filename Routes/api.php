<?php

$router->get('/api', function() use ($container){
    header('content-type: application/json');
    echo '{"value": "API Home"}';
});