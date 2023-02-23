<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Block Buster</title>
        <link rel="stylesheet" href="<?php echo $this->assets('css/style.css'); ?>" />
        <link rel="stylesheet" href="<?php echo $this->assets('css/pagination.css'); ?>" />
    </head>
    <body>
        <?php
         $this->RenderFile('nav.php' , $PARAMS );
        ?>
        
        <div id="content-wraper"> 
            <?php
                $this->RenderContent();
            ?>
        </div>
        
        <?php
         $this->RenderFile('footer.php' , $PARAMS );
        ?>
        
    </body>
</html>
