<div id="categories-wrraper">
<?php

foreach ($PARAMS as $cateogry){
   
    echo '<a href="/categories/' . strtolower( $cateogry['name'] ) . 
         '"><div class="category-option">' . $cateogry['name'] . '</div></a>';
}

?>
</div>