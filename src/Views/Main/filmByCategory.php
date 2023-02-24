<?php
    
    if(array_key_exists('url_base', $PARAMS) ){

        $url = array_pop($PARAMS);
    }

    if(array_key_exists('pagination', $PARAMS) ){

        $pagination = array_pop($PARAMS);
    }
    
    
    $CatName = array_pop($PARAMS);
?>

<h1><?php echo $CatName; ?></h1>
<?php

    $this->RenderFile('movies.php' , $PARAMS );
    
    if( isset($pagination) ){
        
        $this->paginate( $pagination, $url );
    }
        
?>