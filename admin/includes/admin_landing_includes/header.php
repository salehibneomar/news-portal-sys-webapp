<?php
  ob_start();
  session_start();
  require 'config/db.php';

  if(isset($_SESSION['userData'])){
    if(!empty(trim($_SESSION['userData']['name'])) && (!empty(trim($_SESSION['userData']['phone'])) || !empty(trim($_SESSION['userData']['email'])))){
      header("Location: dashboard.php");
      exit();
    }
  }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- toaster -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">

  
  <!--Developer custom css -->
  <link rel="stylesheet" href="custom/css/style.css">

</head>