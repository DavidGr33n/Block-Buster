<h1>Most Rented Movies</h1>

<?php

foreach( $PARAMS as $movie ){
    
    echo '<div class="movie-wrraper">';
    
    $id = $movie['film_id'];
    $name = $movie['title'];
    $rentCount = $movie['rentCount'];
    
     echo '<h1><a href="' . DOMAIN . 'movies/' . $id . '">' . $name . '</a>'
        . '<span> Was rented : ' . $rentCount . ' times!!!</span>'
        . '</h1>';
    
    echo'</div>';
}

?>
