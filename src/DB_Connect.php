<?php

namespace BlockBuster\app;

use \PDO;
/**
 * 
 *
 * @author david
 */
class DB_Connect {
    
   private $servername = "localhost";
   private $username = "root";
   private $password = "root";
   private $dbname = "sakila";
   public $conn;
   
   protected static $instance = null;
   
   
   public function __destruct() {
       
       $this->conn = null;
   }


   protected function __construct() {
       
      try {
          
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $this->conn = $conn;
        
        }   catch(PDOException $e)   {
            
            echo "Connection failed: " . $e->getMessage();
        } 
   }
   
   public static function GetInstance(){
       
       if( self::$instance === null ){
           
           self::$instance = new DB_Connect();
       }
       
       return self::$instance;
   }
}
