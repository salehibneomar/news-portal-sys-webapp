<?php

    $dbInfo =  array(
        'user' => 'root',
        'pass' => '',
        'db'   => 'php_news_portal',
        'host' => '127.0.0.1'
    );

    $conn = mysqli_connect($dbInfo['host'], $dbInfo['user'], $dbInfo['pass'], $dbInfo['db']);

    if(!$conn){
        die("<br><b>Error: </b>".mysqli_connect_error());
    }

?>