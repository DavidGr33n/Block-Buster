<?php

require '../src/router.php';

use BlockBuster\Router;


$router = new Router();

$router->get('get', function(){
    
    echo 'home page!';
});