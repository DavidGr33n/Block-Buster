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
    public $frameFile;
    public $CONTENT;
    public $ContentParms;


    public function __construct($viewName) {
        
        $this->viewName = $viewName;
        
        $ViewDir = self::VIEWS_DIR . $viewName ;
        
        if(file_exists($ViewDir) ){
            
            $this->thisViewDir = $ViewDir . '/';
        }
    }
    
    public function RenderFile( $fileName , $PARAMS = array() ){
        
        $filePath = $this->thisViewDir . $fileName;
        
        if( file_exists( $filePath ) ){
            
            if( is_array($PARAMS) && !empty($PARAMS) ){
                
                foreach ($PARAMS as $key => $value) {
                    
                    $$key = $value;
                } 
            }
            
            include ($filePath);
        }
    }
    
    public function SetViewFrame( $fileName ){
        
        $filePath = $this->thisViewDir . $fileName;
        
        if( file_exists( $filePath ) ){
            
            $this->frameFile = $fileName;
        }
    }
    
    public function RenderViewFrame( $content , $PARAMS = array() ) {
        
        $this->CONTENT = $content;  //sets the content for the render content function
        
        
        /*
         * if $PARAMS is not empty array than set the {{this}}->$ContentParms
         * else  {{this}}->$ContentParms remains NULL.
         */
        if( !empty( $PARAMS ) ){
            
            $this->ContentParms = $PARAMS;
        }
        
        
        //Actuate the frame
        $this->RenderFile( $this->frameFile , $PARAMS );
    }
    
    
    public function RenderContent() {
        
        $extensions = array( '.php' , '.PHP' , '.html' , '.HTML');
        $content = $this->CONTENT;
        
        
        foreach ($extensions as $ext) {
            
            if( str_ends_with($content, $ext) ){
                
                $PARAMS = ( $this->ContentParms !== null ) ? $this->ContentParms : array();
                
                $this->RenderFile( $content , $PARAMS );
                return;
            }
        }
        
        echo $content;
    }
}
