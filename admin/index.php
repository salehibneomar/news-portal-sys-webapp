<?php include 'includes/admin_landing_includes/header.php'; ?>

<body class="hold-transition login-page">

<div class="login-box">

  <div class="login-logo">
    <a href="index.php"><b>Admin</b> Login</a>
  </div>

  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>
    
      <?php
          $emailOrPhone="";

            if(isset($_POST['login'])){ 
                extract($_POST);

                $emailOrPhone     = mysqli_real_escape_string($conn, trim($emailOrPhone));
                $password         = mysqli_real_escape_string($conn, trim($password));
                $formErrors       = array();
                $emptyCredentials =false;

                if(empty($emailOrPhone)){
                  array_push($formErrors, 'Email/Phone is empty!');
                  $emptyCredentials = true;
                }

                if(empty($password)){
                  array_push($formErrors, 'Password is empty!');
                  $emptyCredentials = true;
                }

                $data = null;

                if($emptyCredentials==false){
                    $password = SHA1($password);

                    $query    = "SELECT * FROM user WHERE  password='$password' AND ( email='$emailOrPhone' OR   phone='$emailOrPhone' ) ";
                    $result = mysqli_query($conn, $query);

                    if(mysqli_num_rows($result)==1){
                      $data = mysqli_fetch_assoc($result);

                      if($data['status']==0){
                        array_push($formErrors, 'Your ID is In-active, contact a super admin.');
                        $data = null;
                      }
                    }
                    else{
                      array_push($formErrors, 'Invalid Login credentials!');
                    }
                }
                
                if(!empty($formErrors)){
                    $_SESSION['toastr']['message']   = $formErrors;
                    $_SESSION['toastr']['alertType'] = "danger";
                }
                else if($data!=null){
                  $_SESSION['userData']      = array();
                  $_SESSION['userData']      = $data;
                  $_SESSION['userActivityTimeTrack'] = time();
              
                  header("Location: dashboard.php");
                  exit();
                }
            }
      ?>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Email or Phone" name="emailOrPhone" value="<?=$emailOrPhone; ?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <i class="fas fa-user-shield"></i>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="login">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>


      <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgot-password.php">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.php" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<?php include 'includes/admin_landing_includes/footer.php'; ?>
