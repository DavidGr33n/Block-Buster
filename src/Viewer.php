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
    
    public function assets( $assetPath ){ //path inside the assets folder
        
        return DOMAIN. 'assets/' . $assetPath;
    }
    
    
    public function paginate( $pages_info_arr , $url ) {
        
        echo '<div class="pagination__wrapper"><ul class="pagination">';
        
        
        if( $pages_info_arr['previous'] !== null ){
                
            echo'<li><a href="' . $url . '?p=' . $pages_info_arr['previous']. '">'
              . '<button class="prev" title="previous page">&#10094;</button></a></li>';
        }
        
        
        $is_active_class = $pages_info_arr['this'] === 1 ? 'class="active"' : '';
        echo'<li><a href="' . $url . '?p=1">'
          . '<button ' . $is_active_class . ' title="First page - page 1">1</button></a></li>';
        
        
        $max = $pages_info_arr['total'];
        
        if( $pages_info_arr['total'] < 6 ){
            
            $max--;
            
            $i = 1;
            
            for( $i; $i < $max ; $i++ ){
                
                $t = $i+1;
                
                $is_active_class = $pages_info_arr['this'] === $t  ? 'class="active"' : '';
                
                echo'<li><a href="' . $url . '?p=' . $t . '">'
                 . '<button ' . $is_active_class . ' title="page ' . $t . '">' . $t . '</button></a></li>';
            }
            
        }else{
            
            $thisPage = $pages_info_arr['this'];
            $nextPage = $thisPage + 1;
            $previousPage = $thisPage - 1;
            
            if ( $previousPage < 3 ){ //in this case this page is 3,2 or 1
                
                //echo < page 2>
                //echo < page 3>
                //echo < page 4>
                //echo <.....>
                
                $is_active_class = $thisPage === 2 ? 'class="active"' : '';
                echo'<li><a href="' . $url . '?p=2"><button ' . $is_active_class . ' title="page 2">2</button></a></li>';
                
                $is_active_class = $thisPage === 3 ? 'class="active"' : '';
                echo'<li><a href="' . $url . '?p=3"><button ' . $is_active_class . ' title="page 3">3</button></a></li>';
                
                echo'<li><a href="' . $url . '?p=4"><button title="page 4">4</button></a></li>';
                echo'<li><span>...</span></li>';
                
            } elseif ( $nextPage < $max  ){ 
                
                //echo <.....>
                //echo <X-1 page>
                //echo <X page>
                //echo <X+1 page>
                //echo <.....>

                echo'<li><span>...</span></li>';
                echo'<li><a href="' . $url . '?p=' . $previousPage . '"><button title="page ' . $previousPage . '">' . $previousPage . '</button></a></li>';
                echo'<li><a href="' . $url . '?p=' . $thisPage . '"><button class="active" title="page ' . $thisPage . '">' . $thisPage . '</button></a></li>';
                echo'<li><a href="' . $url . '?p=' . $nextPage . '"><button title="page ' . $nextPage . '">' . $nextPage . '</button></a></li>';
                
                if( ($nextPage + 1) < $max   ){
                    
                    echo'<li><span>...</span></li>';
                }
                
                
            } elseif( $nextPage == $max ) {
                
                //echo <.....>
                //echo <last -3 page>
                //echo <last -2 page>
                //echo <last -1 page>
                
                $th1 = $previousPage -1;
                
                echo'<li><span>...</span></li>';
                echo'<li><a href="' . $url . '?p=' . $th1 . '"><button title="page ' . $th1  . '">' . $th1 . '</button></a></li>';
                echo'<li><a href="' . $url . '?p=' . $previousPage . '"><button title="page ' . $previousPage . '">' . $previousPage . '</button></a></li>';
                echo'<li><a href="' . $url . '?p=' . $thisPage . '"><button class="active" title="page ' . $thisPage . '">' . $thisPage . '</button></a></li>';
                
            }else{
                
                $th1 = $previousPage -1;
                $th2 = $previousPage -2;
                
                echo'<li><span>...</span></li>';
                echo'<li><a href="' . $url . '?p=' . $th2 . '"><button title="page ' . $th2  . '">' . $th2 . '</button></a></li>';
                echo'<li><a href="' . $url . '?p=' . $th1 . '"><button title="page ' . $th1  . '">' . $th1 . '</button></a></li>';
                echo'<li><a href="' . $url . '?p=' . $previousPage . '"><button title="page ' . $previousPage . '">' . $previousPage . '</button></a></li>';
            }
        }
        
        
        $is_active_class = $pages_info_arr['this'] == $pages_info_arr['total'] ? 'class="active"' : '';
        
        echo'<li><a href="' . $url . '?p=' . $pages_info_arr['total'] . '"><button ' . $is_active_class . ' title="Last page - page ' .
            $pages_info_arr['total'] . '">'. 
            $pages_info_arr['total'] . '</button></a></li>';
        
        
        if( $pages_info_arr['next'] !== null ){
                
            echo'<li><a href="' . $url . '?p=' . $pages_info_arr['next'] . '"><button class="next" title="next page">&#10095;</button></a></li>';    
        }
        
        
        echo '</ul></div>';
    }
}
