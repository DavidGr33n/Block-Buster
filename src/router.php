<?php

namespace BlockBuster\app;

/**
 * Description of router
 *
 * @author david
 */
class Router {
    
    private $handlers = array();
    public $notFoundHandler;
    public $method;
    public $requestPath;
    public $ControllerInfo;
    public $Controller;


    public function get(string $path, $handler): void {
        
        $this->addHandler($path, 'GET', $handler);
    }
    
    
    public function post(string $path, $handler): void {
        
        $this->addHandler($path, 'POST', $handler);
    }
    
    
    public function set() {
        
    }
    
    
    public function run(): void {
        
        $requestUrl = parse_url( $this->GetSanitizedUrl() );
        $this->requestPath = $requestUrl['path'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        
        $callBack = null;
        
        foreach ($this->handlers as $config){
            
            
            if($config['path'] === $this->requestPath && $this->method === $config['method']){
                
                $callBack = $config['handler'];
            }
        }
        
        /*
         * If $callback is not given a value (anonymus function or controller name)
         * its value will be null so it will refer to not found page
         */
        
        if(!$callBack){
            header('HTTP/1.0 404 Not Found');
            
            if( !empty($this->notFoundHandler) ){
                
                $callBack = $this->notFoundHandler;
            }
            
        }
        
        //cheak if $callback is a anonymus fuction or if it is a strig - if it is a string
        //it is expected to be a controller name + a method to call on the controoler.
        
        if( $callBack instanceof \Closure && is_callable($callBack) ){
            
            call_user_func($callBack);
            
        } elseif( gettype($callBack) === 'string'  &&  $this->ParseControllerName($callBack) === true ){
            
            require_once $this->ControllerInfo['File'];
            
            $className = $this->ControllerInfo['Class'];
            $classMethod = $this->ControllerInfo['Method'];
            
            if( class_exists($className) && method_exists( $className , $classMethod) ){
                
                //init the Controller base class and give it acess to the Router object.
                Controller::$router = $this;
                
                $this->Controller = new $this->ControllerInfo['Class'];
                
                call_user_func( array( $this->Controller , $classMethod ) );
                
            }else{
                
                header('HTTP/1.0 500 Internal Server Error');
                die();
            }
            
        }else{
            
            header('HTTP/1.0 500 Internal Server Error');
            die();
        }
        
        
    }
    
    
    public function ParseControllerName( $name ){
        
        if( strpos($name,'@') === false ){
            
            return false;
        }
        
        $name = explode("@", $name);
        
        if( count($name) !== 2 ){
            return false;
        }
        
        $ContFileName = '../src/Controllers/' . $name[0] . '_Controller.php';
        
        
        
        if( !file_exists($ContFileName) ){
            
            return false;
        }
        
        $this->ControllerInfo = [ 
            
            'File' => $ContFileName ,
            'Method' => $name[1],
            'Class' => $name[0] . '_Controller'
        ];
        
        return true;  
    }
    
    
    public function Handler404( $callBack ):void{
        
        $this->notFoundHandler = $callBack;
    }


    protected function GetSanitizedUrl(): string {
        
        $rawUrl = $_SERVER['REQUEST_URI'];
        $rawUrl = urldecode($rawUrl);
        
        return filter_var($rawUrl, FILTER_SANITIZE_URL);
        
    }

    private function addHandler(string $path, string $method ,$handler){
        
        $this->handlers[$method. $path] = [
            
            'path' => $path,
            'method' => $method,
            'handler' => $handler
        ];
        
    }
    
}
