<?php

if(array_key_exists('url_base', $PARAMS) ){

        $url = array_pop($PARAMS);
}

if(array_key_exists('pagination', $PARAMS) ){
    
    $pagination = array_pop($PARAMS);
}

foreach( $PARAMS as $movie ){
    
    $thisMovie = new BlockBuster\app\Movie( $movie );
    
    echo '<div class="movie-wrraper">';
    
    echo '<h1><a href="' . DOMAIN . 'movies/' 
       . $thisMovie->film_id . '">' . $thisMovie->title . '</a></h1>';
    
    foreach ( $movie as $key => $value ){
        
        echo $key . " : " . $value;
        echo '<br/>';
    }
    
    if( isset($thisMovie->catName) ){
        
        echo 'Category Name : ' . '<a href="' . DOMAIN . 'categories/' 
            . $thisMovie->catName . '">' . $thisMovie->catName . '</a>'; 
    }
    
    echo '</div>';
}

if( isset($pagination) ){
    
    $this->paginate( $pagination , $url );
}
?>

