<?php include 'includes/header.php'; ?>

<?php
    if($hasLoggedInVisitor){
        header("Location: index.php");
        exit();
    }
?>

    <!-- :::::::::: Page Banner Section Start :::::::: -->
    <section class="sub-page-section">

    </section>
    <!-- ::::::::::: Page Banner Section End ::::::::: -->



    <!-- :::::::::: Blog With Right Sidebar Start :::::::: -->
    <section>
        <div class="container">
            <div class="row">
                
                <div class="col-md-8">

                <?php if($operation=="login"){ ?>
                    <div class="widget">
                        <h4>Login Panel</h4>
                        <div class="title-border mb-5"></div>

                        <!-- Form Start -->
                        <form action="login-register.php?operation=login" method="post" class="contact-form">
                            
                            <div class="row">
                                
                                <div class="col-md-12 mb-2">

                                    <div class="form-group mb-4">
                                        <input type="email" name="email" placeholder="Email" class="form-input" autocomplete="on" required="required">
                                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                    </div>
                                    <div class="form-group mb-4">
                                        <input type="password" name="password" placeholder="Password" class="form-input" autocomplete="off" required="required" minlength="6" maxlength="32">
                                        <i class="fa fa-key" aria-hidden="true"></i>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="customControlInline">
                                            <label class="custom-control-label" for="customControlInline">Keep me logged in</label>
                                        </div>
                                    </div>

                                </div>
                                
                                <div class="col-md-12 mb-4">
                                    <button type="submit" class="btn-main" name="login" id="test">Login&ensp;<i class="fa fa-sign-in" aria-hidden="true"></i></button>
                                </div>

                                <div class="col-md-12 mb-3" >
                                    <a href="" style="text-decoration: underline;">Forgot password?</a>
                                </div>

                            </div>
                            
                        </form>
                        <!-- Form End -->

                        <?php
                            if(isset($_POST['login'])){
                                extract($_POST);
                                
                                $email    = mysqli_real_escape_string($conn, trim($email));
                                $password = mysqli_real_escape_string($conn, trim($password));
                                
                                $formErrors       = array();
                                $emptyCredentials = false;

                                if(empty($email)){
                                    $formErrors[]="Email is empty!";
                                    $emptyCredentials = true;
                                }
                                
                                if(empty($password)){
                                    $formErrors[]="Password is empty!";
                                    $emptyCredentials = true;
                                }

                                $data = null;
                                if(!$emptyCredentials){

                                    $password = SHA1($password);
                                    $query = "SELECT * FROM site_visitor WHERE email='$email' AND password='$password' LIMIT 1";

                                    $result = mysqli_query($conn, $query);

                                    if(mysqli_num_rows($result)==1){
                                        $data = mysqli_fetch_assoc($result);
                  
                                        if($data['status']==2){
                                          $formErrors[]= 'Your ID is Suspended! contact us for more details.';
                                          $data = null;
                                        }
                                        
                                      }
                                      else{
                                        $formErrors[]= 'Invalid Login credentials!';
                                      }
                                }

                                if(!empty($formErrors)){
                                    $_SESSION['toastr']['message']   = $formErrors;
                                    $_SESSION['toastr']['alertType'] = 'error';
                                }
                                else if($data!=null){

                                    if($data['status']==3){
                                        $vid    = $data['vid'];
                                        $query  = "UPDATE site_visitor SET status=1 WHERE vid='$vid'";
                                        mysqli_query($conn, $query);
                                    }

                                    $_SESSION['visitorData'] = $data;
                                    $_SESSION['visitorActivityTimeTract'] = time();
                                    
                                    $redirect = (isset($_SESSION['prevSinglePage'])) ? $_SESSION['prevSinglePage'] : "index.php";
                                    
                                    header("Location: {$redirect}");
                                    exit();
                                }
                                
                            }
                        ?>
                    </div>
                <?php }else if($operation=="register"){ ?>
                    <div class="widget">
                        <h4>Registration Panel</h4>
                        <div class="title-border mb-5"></div>

                        <!-- Form Start -->
                        <form action="login-register.php?operation=register" method="post" class="contact-form">
                            
                            <div class="row">
                                
                                <div class="col-md-12 mb-2">
                                    <div class="form-group mb-4">
                                        <input type="text" name="name" placeholder="Name" class="form-input" autocomplete="off" required="required" minlength="3" maxlength="150">
                                        <i class="fa fa-user-o" aria-hidden="true"></i>
                                    </div>
                                    <div class="form-group mb-4">
                                        <input type="email" name="email" placeholder="Email" class="form-input" autocomplete="off" required="required">
                                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                    </div>
                                    <div class="form-group mb-4">
                                        <input type="password" name="password" placeholder="Password" class="form-input" autocomplete="off" required="required" minlength="6" maxlength="32">
                                        <i class="fa fa-key" aria-hidden="true"></i>
                                    </div>
                                    <div class="form-group mb-4">
                                        <input type="password" name="retyped_password" placeholder="Retype-password" class="form-input" autocomplete="off" required="required" minlength="6" maxlength="32">
                                        <i class="fa fa-key" aria-hidden="true"></i>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="customControlInline" required>
                                            <label class="custom-control-label" for="customControlInline">I've read the terms and conditions</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <button type="submit" class="btn-main" name="register">Register&ensp;<i class="fa fa-user-plus" aria-hidden="true"></i></button>
                                </div>

                            </div>
                            
                        </form>
                        <!-- Form End -->

                        <?php 
                            if(isset($_POST['register'])){
                                extract($_POST);

                                $name             = mysqli_real_escape_string($conn, trim($name));
                                $email            = mysqli_real_escape_string($conn, trim($email));
                                $password         = mysqli_real_escape_string($conn, trim($password));
                                $retyped_password = mysqli_real_escape_string($conn, trim($retyped_password));
                                $formErrors       = array();

                                if(empty($name)){
                                    $formErrors[]="Empty name!";
                                }
                                else if(preg_match("/^[A-z\s]+$/", $name)==false){
                                    $formErrors[]="Invalid name charcters!";
                                }
                                else{
                                    $name = ucwords($name);
                                }
                                
                                if(empty($email)){
                                    $formErrors[]="Empty email!";
                                }
                                else{
                                    $email = strtolower($email);
                                }

                                if(empty($password)){
                                    $formErrors[]="Empty password!";
                                }
                                else{
                                    if($password!=$retyped_password){
                                        $formErrors[]="Password and Retyped-password didn\\'t match!";
                                    }
                                    else{
                                        $password = SHA1($password);
                                    }
                                }

                                if(!empty($formErrors)){
                                    $_SESSION['toastr']['message']   = $formErrors;
                                    $_SESSION['toastr']['alertType'] = 'error';
                                }
                                else{
                                    
                                    $query = "SELECT * FROM site_visitor WHERE email='$email' AND password='$password' LIMIT 1";

                                    $result = mysqli_query($conn, $query);

                                    if(mysqli_num_rows($result)==1){
                                        $_SESSION['toastr']['message']   = array("This email is already registered!");
                                        $_SESSION['toastr']['alertType'] = 'error';
                                    }
                                    else{
                                        $dateRegistered = date('Y-m-d');

                                        $query = "INSERT INTO site_visitor(name, email, password, dateRegistered, status)
                                        VALUES('$name', '$email', '$password', '$dateRegistered', 1)";

                                        $result = mysqli_query($conn, $query);

                                        if($result){
                                            $_SESSION['toastr']['message']   = array("Account created successfully! Login using your credentials.");
                                            $_SESSION['toastr']['alertType'] = 'success';
                                            header("Location: login-register.php?operation=login");
                                            exit();
                                        }
                                        else{
                                            $_SESSION['toastr']['message']   = array("Fatal error occured! Try again later.");
                                            $_SESSION['toastr']['alertType'] = 'error';
                                        }
                                    }
                                }

                            }
                        ?>

                    </div>
                <?php }else { header("Location: index.php"); exit(); } ?>
                </div>

                <!-- Blog Right Sidebar -->
                <?php include 'includes/aside.php'; ?>
                <!-- Right Sidebar End -->
            </div>
        </div>
    </section>
    <!-- ::::::::::: Blog With Right Sidebar End ::::::::: -->
    


<?php include 'includes/footer.php'; ?>

<?php include 'includes/bottom.php'; ?>
