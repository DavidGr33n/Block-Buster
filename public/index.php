<?php

require '../src/router.php';

use BlockBuster\app\Router;


$router = new BlockBuster\app\Router();

$router->get('/', function(){
    
    echo 'home page!';
});

$router->get('/about', function(){
    
    echo 'about us';
});

$router->Handler404( function(){
    echo'<h1>Not Found Page!!</h1>';
});


$router->run();