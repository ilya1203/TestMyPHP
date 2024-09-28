<?php
    
    $db = array(
        "server" => "81.31.247.100:3306",
        "login" => "DpVFsp",
        "password" => "nhXQtqGWYwAsgCUo"
    );
    
    $connect = new mysqli($db["server"], $db["login"], $db["password"]);
      
    if(!$connect) 
    {
        die("Connection failed: " . mysqli_connect_error());
        exit();
    }
    else{
        mysqli_select_db($connect, "YkvHJahZ");
    }
    
?>