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
        $requestPath = $requestUrl['path'];
        $method = $_SERVER['REQUEST_METHOD'];
        
        $callBack = null;
        
        foreach ($this->handlers as $config){
            
            
            if($config['path'] === $requestPath && $method === $config['method']){
                
                $callBack = $config['handler'];
            }
        }
        
        if(!$callBack){
            header('HTTP/1.0 404 Not Found');
            
            if( !empty($this->notFoundHandler) ){
                
                $callBack = $this->notFoundHandler;
            }
            
        }
        
        call_user_func($callBack);
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
