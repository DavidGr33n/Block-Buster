<?php
    $CatName = array_pop($PARAMS);
?>

<h1><?php echo $CatName; ?></h1>
<?php

    $this->RenderFile('movies.php' , $PARAMS );
        
?>