<?php



/**
 * The Main site controller
 *
 * @author david
 */
class Main_Controller extends BlockBuster\app\Controller {
    
    //here you set the name of your view for this controller
    //and it needs to be the same as the name of the folder in your /src/views/..your folder name../
    const ViEW_NAME = 'Main';  
    
    public $VIEWER;
    
    
    public function __construct() {
        
        $this->VIEWER = new BlockBuster\app\Viewer( self::ViEW_NAME );
    }
    
    
    public function index(){
        
        $this->VIEWER->RenderFile( 'home.php' , array('a' => 10) );
    }
    
    public function test(){
        var_dump( self::$router->requestPath );
    }
}
