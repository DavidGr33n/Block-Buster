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
    
    public function GetFilmsCategory( $category ){
        
        $db = BlockBuster\app\DB_Connect::GetInstance();
        
        $sql = "SELECT category_id , name FROM category WHERE name = :category ";
        
        $sth = $db->conn->prepare( $sql );
        if( $sth->execute( [ 'category' => $category ] ) ){
            
            $cat = $sth->fetch( PDO::FETCH_ASSOC );
            
            
            if( $cat === false ){
                
                header("Location:" . DOMAIN . "categories");
                exit();
            }
            
            
            $catId = $cat['category_id'];
            $catName = $cat['name'];
        }
        
        
        $sql = "SELECT film.* FROM film "
             . "JOIN film_category ON film.film_id = film_category.film_id "
             . "JOIN category ON film_category.category_id = category.category_id "
             . "WHERE category.category_id = :catid";
        
        $sth = $db->conn->prepare( $sql );
        if( $sth->execute( [ 'catid' => $catId ] ) ){
            
            $movies = $sth->fetchAll( PDO::FETCH_ASSOC );
        }
        
        $movies[] = $catName;
        
        $this->VIEWER->RenderViewFrame( 'filmByCategory.php' , $movies  );
    }
    
    
    public function GetMostRentedMovies(){
        
        $db = BlockBuster\app\DB_Connect::GetInstance();
        
        $sql = 'SELECT COUNT(rental.rental_id) AS rentCount , film.title , inventory.film_id '
             . 'FROM rental JOIN inventory ON rental.inventory_id = inventory.inventory_id '
             . 'JOIN film ON inventory.film_id = film.film_id '
             . 'GROUP BY inventory.film_id, film.title '
             . 'ORDER BY rentCount DESC LIMIT 10';
        
        $sth = $db->conn->query($sql , PDO::FETCH_ASSOC);
        
        $top10moviesRent = $sth->fetchAll();
        
        $this->VIEWER->RenderViewFrame( 'mostRented.php' , $top10moviesRent  );
    }
    

    public function test(){
        var_dump( self::$router->requestPath );
    }
}
