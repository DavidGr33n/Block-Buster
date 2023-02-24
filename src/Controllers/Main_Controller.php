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
    const PAGINATION_STEP = 15;   //the number of elemnts to show per page
    
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
        
        $sql = "SELECT film.* , category.name AS catName "     //selects all films with their category names
             . "FROM film JOIN film_category "
             . "ON film.film_id = film_category.film_id "
             . "JOIN category ON film_category.category_id = category.category_id "
             . "ORDER BY `film`.`film_id` ASC ";
        
        
        $res = $this->prepere_pagination( [ 'results_sql' => $sql ] );
        
        $sql = $res['results_sql'];
        $pagination = $res['pagination'];
        
        
        $movies = $db->conn->query($sql , PDO::FETCH_ASSOC)->fetchAll();
        
        
        if( $pagination !== null ){
            
            $url_base = DOMAIN . ltrim(self::$router->requestPath, '/');
            
            $movies['pagination'] = $pagination;
            $movies['url_base'] = $url_base;
        }
        
        
        $this->VIEWER->RenderViewFrame( 'movies.php' , $movies );
    }
    
    
    public function GetMovieById( $id ){
        
        $db = BlockBuster\app\DB_Connect::GetInstance();
        
        $sql = "SELECT film.* , category.name AS catName FROM film JOIN film_category "
             . "ON film.film_id = film_category.film_id "
             . "JOIN category ON film_category.category_id = category.category_id "
             . "WHERE film.film_id = :film_id ";
        
        $sth = $db->conn->prepare( $sql );
        if( $sth->execute( [ 'film_id' => $id ] ) ){
            
            $movie = $sth->fetchAll( PDO::FETCH_ASSOC );
            
            
            if( empty($movie) ){
                
                header("Location:" . DOMAIN . "movies");
                exit();
            }
        }
        
       $this->VIEWER->RenderViewFrame( 'movies.php' , $movie ); 
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
             . "WHERE category.category_id = :catid ";
        
        
        $count_arr = ['column' => 'film.film_id' , 
                      'table' => 'film' ,
                      'sql' => 'JOIN film_category ON film.film_id = film_category.film_id '
                             . 'JOIN category ON film_category.category_id = category.category_id '
                             . 'WHERE category.category_id = ' . $catId . ' ' 
                     ];
        
        
        $res = $this->prepere_pagination( [ 'results_sql' => $sql , 'count_parm_arr' => $count_arr ] );
        
        
        $sql = $res['results_sql'];
        $pagination = $res['pagination'];
        
        
        $sth = $db->conn->prepare( $sql );
        if( $sth->execute( [ 'catid' => $catId ] ) ){
            
            $movies = $sth->fetchAll( PDO::FETCH_ASSOC );
        }
        
        $movies[] = $catName;
        
        
        if( $pagination !== null ){
            
            $url_base = DOMAIN . ltrim(self::$router->requestPath, '/');
            
            $movies['pagination'] = $pagination;
            $movies['url_base'] = $url_base;
        }
        
        
        
        $this->VIEWER->RenderViewFrame( 'filmByCategory.php' , $movies  );
    }
    
    
    public function GetMostRentedMovies(){
        
        $db = BlockBuster\app\DB_Connect::GetInstance();
        
        $sql = 'SELECT inventory.film_id , film.title , COUNT(rental.rental_id) AS rentCount '
             . 'FROM rental JOIN inventory ON rental.inventory_id = inventory.inventory_id '
             . 'JOIN film ON inventory.film_id = film.film_id '
             . 'GROUP BY inventory.film_id, film.title '
             . 'ORDER BY rentCount DESC LIMIT 10';
        
        $sth = $db->conn->query($sql , PDO::FETCH_ASSOC);
        
        $top10moviesRent = $sth->fetchAll();
        
        $this->VIEWER->RenderViewFrame( 'mostRented.php' , $top10moviesRent  );
    }
    
    public function getPageNum() {
        
        $query_string_parms = self::$router->query_parms_arr;
        
        
        if( $query_string_parms !== null && array_key_exists('p', $query_string_parms) ){
            
            $pageNUm = intval( $query_string_parms['p'] );
            
            if( $pageNUm > 0 ){
                
                return $pageNUm;
            }
        }
        
        return false;
    }
    
    
    public function countFilms( array $parms = ['column' => 'film_id' , 'table' => 'film' ,'sql' => '' ] ){
        
        $db = BlockBuster\app\DB_Connect::GetInstance();
        
        $column = isset( $parms['column'] ) ? $parms['column'] : 'film_id';
        $table = isset( $parms['table'] ) ? $parms['table'] : 'film';
        
        $sql = "SELECT COUNT($column) AS count FROM $table ";
        
        if( array_key_exists('sql', $parms) && $parms['sql'] !== '' ){
            
            $sql .= $parms['sql'];
        }
        
        
        $sth = $db->conn->query( $sql );
        
        $films_count = $sth->fetch( PDO::FETCH_ASSOC );
        
        
        return $films_count['count'];
    }
    
    
    public function prepere_pagination( array $parms = [ 'results_sql' => 'SELECT * FROM film '  ] ){
        
        $page_num = $this->getPageNum();
        $pagination = null;
        $sql = $parms['results_sql'];
        
        
        if( $page_num !== false ){
            
            $sql .= "LIMIT " . self::PAGINATION_STEP 
                 . " OFFSET " . ( ($page_num - 1) * self::PAGINATION_STEP );
            
        }else{
            
            $sql .= "LIMIT " . self::PAGINATION_STEP;
            $page_num = 1;
        }
        
        
        $films_count = array_key_exists('count_parm_arr', $parms) ? 
                       $this->countFilms( $parms['count_parm_arr'] ) : 
                       $this->countFilms()  ;
        
        
        if( $films_count > 0 ){
                
            $total_pages = ceil( $films_count/self::PAGINATION_STEP ); //Rounds up floats to get total pages count
            
            if( $total_pages > 1 && $page_num <= $total_pages ){
                
                //set next page and previous page for the pagniation feature
                $next_page = ($page_num + 1) > $total_pages ? null : $page_num + 1;
                
                $previous_page = ($page_num - 1) < 1 ? null : $page_num - 1;
                
                $pagination = [ 'next' => $next_page ,
                                'previous' => $previous_page, 
                                'this' => $page_num,
                                'total' => $total_pages   
                ];
            }
        }
        
        return [ 'results_sql' => $sql , 'pagination' => $pagination ];
    }


    public function test(){
        var_dump( self::$router->requestPath );
    }
}
