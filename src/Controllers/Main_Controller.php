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
        
        $this->VIEWER->SetViewFrame( 'frame.php' );
    }
    
    
    public function index(){
        
        $db = BlockBuster\app\DB_Connect::GetInstance();
        
        $this->VIEWER->RenderViewFrame( 'home.php');
    }
    
    public function GetMovies(){
        
        $db = BlockBuster\app\DB_Connect::GetInstance();
        
        $sql = "SELECT film.* , category.name "     //selects all films with their category names
             . "FROM film JOIN film_category "
             . "ON film.film_id = film_category.film_id "
             . "JOIN category ON film_category.category_id = category.category_id "
             . "ORDER BY `film`.`film_id` ASC ";
        
        $movies = $db->conn->query($sql , PDO::FETCH_ASSOC)->fetchAll();
        
        $this->VIEWER->RenderViewFrame( 'movies.php' , $movies );
    }
    
    public function GetCategories(){
        
        $db = BlockBuster\app\DB_Connect::GetInstance();
        
        $sql = "SELECT name FROM category";
        
        $categories = $db->conn->query($sql , PDO::FETCH_ASSOC)->fetchAll();
        
        $this->VIEWER->RenderViewFrame( 'categories.php' , $categories );
    }
    
    public function test(){
        var_dump( self::$router->requestPath );
    }
}
