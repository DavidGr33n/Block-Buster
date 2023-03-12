<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Block Buster</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo $this->assets('css/pagination.css'); ?>" />
        <link rel="stylesheet" href="<?php echo $this->assets('css/style.css'); ?>" />
        <script type="text/javascript" src="<?php echo $this->assets('js/app.js'); ?>"></script>
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
