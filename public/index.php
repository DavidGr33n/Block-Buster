<?php

require_once  '../src/router.php';
require_once  '../src/Controllers/Controller.php';
require_once  '../src/Viewer.php';
require_once  '../src/DB_Connect.php';

use BlockBuster\app\Router;


define("DOMAIN", "http://www.buster.dev/");



$router = new BlockBuster\app\Router();

$router->get('/', 'Main@index' );

$router->get('/movies', 'Main@GetMovies' );

$router->get('/categories', 'Main@GetCategories' );

$router->get('/categories/{{category}}', 'Main@GetFilmsCategory' );

$router->get('/mostrented', 'Main@GetMostRentedMovies');


$router->setHandler404( function(){
    echo'<h1>Not Found Page!!</h1>';
});


$router->run();