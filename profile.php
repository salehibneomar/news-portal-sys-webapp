<?php include 'includes/header.php'; ?>

<?php
    if(!$hasLoggedInVisitor){
        header("Location: login-register.php?operation=login");
        unset($_SESSION['prevSinglePage']);
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

                <?php if($operation=="view"){
                    $visitorId = $_SESSION['visitorData']['vid'];
                    $totalPublicComments = $conn->query("SELECT cid FROM site_visitor_comments_on_post WHERE vid='$visitorId' AND status=1")->num_rows;    
                ?>
                    <div class="widget">
                        <h4>Profile</h4>
                        <div class="title-border mb-5"></div>

                        <table class="table">
                            <tr>
                                <td><b>Name</b></td>
                                <td class="text-right"><?=$_SESSION['visitorData']['name']; ?></td>
                            </tr>
                            <tr>
                                <td><b>Email</b></td>
                                <td class="text-right"><?=$_SESSION['visitorData']['email']; ?></td>
                            </tr>
                            <tr>
                                <td><b>Joined</b></td>
                                <td class="text-right"><?= date('jS M y',strtotime($_SESSION['visitorData']['dateRegistered'])); ?></td>
                            </tr>
                            <tr>
                                <td><b>Total Comment Posted</b></td>
                                <td class="text-right"><span class="btn-main d-inline-block px-3 py-1"><?=$totalPublicComments; ?></span></td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="2">
                                    <a href="profile.php?operation=edit" class="btn-main">Edit Profile</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php }else if($operation=="edit"){ ?>
                    <div class="widget">
                        <h4>Edit Profile</h4>
                        <small class="text-muted">We're not letting our users change their email address.</small>
                        <div class="title-border mb-5"></div>

                        <!-- Form Start -->
                        <form action="profile.php?operation=edit" method="post" class="contact-form">
                            
                            <div class="row">
                                
                                <div class="col-md-12 mb-2">
                                    <div class="form-group mb-4">
                                        <input type="text" name="name" placeholder="Name" class="form-input" autocomplete="off" required="required" minlength="3" maxlength="150" value="<?=$_SESSION['visitorData']['name']; ?>">
                                        <i class="fa fa-user-o" aria-hidden="true"></i>
                                    </div>
                                    <div class="form-group mb-4">
                                        <input type="password" name="password" placeholder="Password" class="form-input" autocomplete="off" minlength="6" maxlength="32">
                                        <i class="fa fa-key" aria-hidden="true"></i>
                                    </div>
                                    <div class="form-group mb-4">
                                        <input type="password" name="retyped_password" placeholder="Retype-password" class="form-input" autocomplete="off" minlength="6" maxlength="32">
                                        <i class="fa fa-key" aria-hidden="true"></i>
                                    </div>
                                    <input type="hidden" name="editId" value="<?=$_SESSION['visitorData']['vid']; ?>">
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <button type="submit" class="btn-main" name="updateProfile">Update&ensp;<i class="fa fa-edit" aria-hidden="true"></i></button>
                                </div>

                            </div>
                            
                        </form>
                        <!-- Form End -->

                        <?php 
                            if(isset($_POST['updateProfile'])){
                                extract($_POST);

                                $name             = mysqli_real_escape_string($conn, trim($name));
                                $password         = mysqli_real_escape_string($conn, trim($password));
                                $retyped_password = mysqli_real_escape_string($conn, trim($retyped_password));
                                $hasPassword      = false;

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
                                

                                if(!empty($password) && mb_strlen($password)>=6){
                                    if(empty($retyped_password)){
                                        $formErrors[]="Please retype password!";
                                    }
                                    else if($password!=$retyped_password){
                                        $formErrors[]="Password and Retyped-password didn\\'t match!";
                                    }
                                    else{
                                        $password    = SHA1($password);
                                        $hasPassword = true;
                                    }
                                }

                                if(!empty($formErrors)){
                                    $_SESSION['toastr']['message']   = $formErrors;
                                    $_SESSION['toastr']['alertType'] = 'error';
                                }
                                else{
                                
                                    $query = "UPDATE site_visitor SET name='$name' WHERE vid='$editId' LIMIT 1";

                                    if($hasPassword){
                                        $query = "UPDATE site_visitor SET name='$name', password='$password' WHERE vid='$editId' LIMIT 1";
                                    }

                                    $result = mysqli_query($conn, $query);

                                    if($result){

                                        if(mysqli_affected_rows($conn)==0){
                                            $_SESSION['toastr']['message']   = array("No changes!");
                                            $_SESSION['toastr']['alertType'] = 'success';
                                        }
                                        else{
                                            $_SESSION['toastr']['message']       = array("Account updated successfully!");
                                            $_SESSION['toastr']['alertType']     = 'success';
                                            $_SESSION['visitorData']['name']     = $name;
                                            if($hasPassword){
                                                $_SESSION['visitorData']['password'] = $password;
                                            }
                                        }
                                        header("Location: profile.php?operation=view");
                                        exit();
                                    }
                                    else{
                                        $_SESSION['toastr']['message']   = array("Fatal error occured! Try again later.");
                                        $_SESSION['toastr']['alertType'] = 'error';
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
