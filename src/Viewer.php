<?php



namespace BlockBuster\app;  

/**
 * The handler for creating and setting of views
 *
 * @author david
 */
class Viewer {
    
    const VIEWS_DIR = '../src/Views/';
    
    public $viewName;
    public $thisViewDir;
    
    public function __construct($viewName) {
        
        $this->viewName = $viewName;
        
        $ViewDir = self::VIEWS_DIR . $viewName ;
        
        if(file_exists($ViewDir) ){
            
            $this->thisViewDir = $ViewDir . '/';
        }
    }
    
    public function RenderFile( $fileName , $parms = array() ){
        
        $filePath = $this->thisViewDir . $fileName;
        
        if( file_exists( $filePath ) ){
            
            if( is_array($parms) && !empty($parms) ){
                
                foreach ($parms as $key => $value) {
                    
                    $$key = $value;
                } 
            }
            
            include ($filePath);
        }
    }
    
    public function SetViewFrame(){
        
        
    }
    
    public function RenderView() {
        
    }
}
