<?php 
    $conn = new mysqli('sql10.freesqldatabase.com', 'sql10346755', 'xctvGFlmft', 'sql10346755');
    
    if($conn->connect_error) {
      echo $error -> $conn->connect_error;
    }
    
    $conn->set_charset("utf8");
 ?>