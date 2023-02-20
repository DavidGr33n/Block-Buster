<?php
//var_dump($PARAMS[0]);

foreach( $PARAMS as $movie ){
    
    echo '<br/>';
    echo '<br/>';
    echo '<br/>';
    
    foreach ( $movie as $key => $value ){
        
        echo $key . " : " . $value;
        echo '<br/>';
    }
    
}
?>

