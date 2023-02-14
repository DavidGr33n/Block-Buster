<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Block Buster</title>
        <link rel="stylesheet" href="assets/css/style.css" />
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
