<?php
  ob_start();
  date_default_timezone_set('Asia/Dhaka');
  session_start();

  if(isset($_SESSION['userData'])){
    if(empty(trim($_SESSION['userData']['name'])) || 
       empty(trim($_SESSION['userData']['phone']) || 
       empty(trim($_SESSION['userData']['email'])))){
      header("Location: index.php");
      exit();
    }

    if(isset($_SESSION['userActivityTimeTrack'])){
      if(time() - $_SESSION['userActivityTimeTrack'] >= 1200){
        session_unset();
        $_SESSION['toastr']['message']   = array("You have been logged out due to 20 mins of inactivity!");
        $_SESSION['toastr']['alertType'] = 'danger';
        header("Location: index.php");
        exit();
      }
      else{
        $_SESSION['userActivityTimeTrack'] = time();
      }
    }
  }
  else{
    header("Location: index.php");
    exit();
  }
?>