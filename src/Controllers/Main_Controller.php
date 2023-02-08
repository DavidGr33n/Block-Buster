<?php



/**
 * The Main site controller
 *
 * @author david
 */
class Main_Controller extends BlockBuster\app\Controller {
    
    public static $ViewName = 'Main';
    
    public function index(){
        echo 'Home Page!!!';
    }
    
    public function test(){
        var_dump( self::$router->requestPath );
    }
}
