<?php

    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'php_news_portal';

    $conn = mysqli_connect($host, $user, $password, $database);

    if(!$conn){
        die("<br><b>Error: </b>".mysqli_connect_error());
    }

?>