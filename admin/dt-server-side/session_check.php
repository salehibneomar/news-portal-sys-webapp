<?php
  ob_start();
  date_default_timezone_set('Asia/Dhaka');
  session_start();

  if(isset($_SESSION['userData'])){
    if(empty(trim($_SESSION['userData']['name'])) || 
       empty(trim($_SESSION['userData']['phone']) || 
       empty(trim($_SESSION['userData']['email'])))){
      header("Location: ../index.php");
      exit();
    }
  }
  else{
    header("Location: ../index.php");
    exit();
  }
?>