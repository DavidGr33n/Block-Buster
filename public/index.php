<?php

require_once  '../src/router.php';
require_once  '../src/Controllers/Controller.php';
require_once  '../src/Viewer.php';
require_once  '../src/DB_Connect.php';

use BlockBuster\app\Router;


$router = new BlockBuster\app\Router();

$router->get('/', 'Main@index' );


$router->get('/about', function(){
    
    echo 'about us';
});


$router->get('/test', 'Main@test');


$router->Handler404( function(){
    echo'<h1>Not Found Page!!</h1>';
});


$router->run();