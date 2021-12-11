<!DOCTYPE html>  
     <head>  
      <title>Hi there.</title>
     </head>  

     <body>  
      <h1>Please remove this file after confirmation.</h1>
      <p><?php echo 'This docker image running PHP, version: ' . phpversion(); ?></p>
     <?php
           phpinfo();
     ?>
</body>
