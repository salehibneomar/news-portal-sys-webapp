<?php
    require 'config/db.php';
    include 'config/functions.php';

    ob_start();
    date_default_timezone_set('Asia/Dhaka');
    session_start();

    $hasLoggedInVisitor = false;
    if(isset($_SESSION['visitorData'])){
      if(!empty($_SESSION['visitorData']['email']) && !empty($_SESSION['visitorData']['password']) && !empty($_SESSION['visitorData']['vid'])){
        $hasLoggedInVisitor = true;
      }
    }

    $page = basename($_SERVER['PHP_SELF'], '.php');
    
    if($page!="login-register"){
      $queryString = trim($_SERVER['QUERY_STRING']);
      $baseName    = basename($_SERVER['PHP_SELF']);

      $_SESSION['prevSinglePage'] = $baseName;
      if(!empty($queryString)){
        $_SESSION['prevSinglePage'] = basename($_SERVER['PHP_SELF'])."?". $_SERVER['QUERY_STRING'];
      }
      
    }
   
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Website Description -->
    <meta name="description" content="" />
    <meta name="author" content="" />

    <?php

        $page = "Home";
        if($page!="index" || !empty($page)){
          $page = ucwords(str_replace("-", " ", $page));
        }

        $operation = (isset($_GET['operation'])) ? trim(mysqli_real_escape_string($conn, $_GET['operation'])) : "" ;
        

        if($operation=="login"){
          $page = "Login";
        }
        else if($operation=="register"){
          $page = "Register";
        }

    ?>
    <title>SIO-SSB-280 | <?=$page;?></title>

    <!--  Favicons / Title Bar Icon  -->
    <link rel="shortcut icon" href="assets/images/favicon/favicon.png" />
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon/favicon.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon/favicon.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon/favicon.png" />


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">

    <!-- Flat Icon CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/flaticon.css">

    <!-- Animate CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/animate.min.css">

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/owl.theme.default.min.css">

    <!-- Fency Box CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/jquery.fancybox.min.css">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="assets/toastr/toastr.min.css">

    <!-- Theme Main Style CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <!-- Responsive CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
  </head>

  <body>
    <!-- :::::::::: Header Section Start :::::::: -->
    <header class="bg-light">
        <div class="container col-lg-11 col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg  bg-transparent py-4" >
                        <a class="navbar-brand" href="index.php"> <b>SIO-SSB-280</b> </a>
                        
                        <?php if($hasLoggedInVisitor){?>
                          <div class="dropdown ml-auto">
                            <button class="btn-main dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user-o" aria-hidden="true"></i>
                              <?php echo explode(" ", $_SESSION['visitorData']['name'])[0]; ?>&ensp;
                              <i class="fa fa-caret-down" aria-hidden="true"></i>

                            </button>
                            <div class="dropdown-menu bs-dropdown-menu dropdown-menu-right mt-3" aria-labelledby="dropdownMenuButton">
                              <a class="dropdown-item" href="profile.php?operation=view"><i class="fa fa-user-o" aria-hidden="true"></i>&ensp;Profile</a>
                              <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>&ensp;Logout</a>
                            </div>
                        </div>
                        <?php }else{ ?>
                          <div class="btn-group  ml-auto" role="group">
                            <a href="login-register.php?operation=login" class="btn-main login-nav-btn" ><i class="fa fa-sign-in fa-sign-in-nav" aria-hidden="true"></i>&ensp;Login</a>
                            <a href="login-register.php?operation=register" class="btn-main">Register&ensp;<i class="fa fa-user-plus " aria-hidden="true"></i></a>
                          </div>
                        <?php } ?>  
                    </nav>
                </div>
            </div>
        </div>
        <div class="container col-lg-11 col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg  bg-transparent pb-3 pt-2 " >
                    <span class="navbar-brand"></span>
                      <button class="navbar-toggler bg-nav-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                          <i class="fa fa-bars" aria-hidden="true"></i>
                      </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                          <ul class="navbar-nav mx-auto">
                            
                          <?php 
                              $query  = "SELECT name AS 'navCategoryName', id AS 'navCategoryId' FROM category WHERE  status  = 1 AND parent=0 ORDER BY name ASC ";

                              $result = mysqli_query($conn, $query);

                              while($row = mysqli_fetch_assoc($result)){
                                extract($row);

                                $subCategoryQuery  = "SELECT name AS 'navSubCatName', id AS 'navSubCatId' FROM category WHERE parent='$navCategoryId' AND status = 1";
                                
                                $subCategoryResult = mysqli_query($conn, $subCategoryQuery);

                                $countSubCategory  = mysqli_num_rows($subCategoryResult);

                                $spaceReplacedMainCategoryName = str_replace(" ", "_", $navCategoryName);
                          ?>

                            <?php if($countSubCategory==0){ ?>
                              <li class="nav-item">
                                  <a class="nav-link" href="post-by-category.php?category=<?=$spaceReplacedMainCategoryName;?>"><?=$navCategoryName;?></a>
                              </li>
                          <?php } else {?> 

                             <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <?=$navCategoryName;?>
                              </a>
                              <div class="dropdown-menu bs-dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="post-by-category.php?category=<?=$spaceReplacedMainCategoryName;?>">See all from <?=$navCategoryName;?></a>
                                <?php while($row = mysqli_fetch_assoc($subCategoryResult)){ 
                                  extract($row);
                                ?>
                                  <a class="dropdown-item" href="post-by-category.php?category=<?=str_replace(" ", "_", $navSubCatName);?>"><?=$navSubCatName;?></a>
                                <?php } ?>
                              </div>
                            </li>
                            <?php } } ?>
                          </ul>
                        </div>

                      </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- ::::::::::: Header Section End ::::::::: -->
