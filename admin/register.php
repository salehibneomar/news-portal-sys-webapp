<?php include 'includes/admin_landing_includes/header.php'; ?>

<body class="hold-transition register-page">

<div class="register-box">
  <div class="register-logo">
    <a href="index.php"><b>User</b> registration</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <?php

        $name        = "";
        $email       = "";
        $phone       = "";
        $password    = "";
        $re_password = "";

            if(isset($_POST['register'])){
              extract($_POST);
              $alertMessages = array();

              $name        = ucwords(mysqli_real_escape_string($conn, trim($name)));
              $email       = strtolower(mysqli_real_escape_string($conn, trim($email)));
              $phone       = mysqli_real_escape_string($conn, trim($phone));
              $password    = mysqli_real_escape_string($conn, trim($password));
              $re_password = mysqli_real_escape_string($conn, trim($re_password));

              if(empty($name)){
                array_push($alertMessages, 'Name is empty!');
              }
              else if(mb_strlen($name)<3){
                array_push($alertMessages, 'Name is too short!');
              }
              else if(mb_strlen($name)>150){
                array_push($alertMessages, 'Name is too long!');
              }
              else if(strpos($name, "'") || strpos($name, "\"")){
                array_push($alertMessages, 'Invalid name characters!');
              }

              if(empty($email)){
                array_push($alertMessages, 'Email is empty!');
              }

              if(empty($phone)){
                array_push($alertMessages, 'Phone is empty!');
              }

              if(empty($password)){
                array_push($alertMessages, 'Password is empty!');
              }
              else{
                if(strlen($password)<6){
                  array_push($alertMessages, "Password is too short! minimum password size is 6 characters.");
                }
                else if($password!=$re_password){
                  array_push($alertMessages, "Password and Retyped Password didn\\'t match!");
                }
              }

              $query  = "SELECT id FROM user WHERE email='$email' LIMIT 1";
              $result = mysqli_query($conn, $query);

              if(mysqli_num_rows($result)==1){
                array_push($alertMessages, "The email you entered is already registered!");
              }

              $query  = "SELECT id FROM user WHERE phone='$phone' LIMIT 1";
              $result = mysqli_query($conn, $query);

              if(mysqli_num_rows($result)==1){
                array_push($alertMessages, "The phone number you entered is already registered!");
              }

              if(!empty($alertMessages)){
                $_SESSION['toastr']['message']   = $alertMessages;
                $_SESSION['toastr']['alertType'] = "danger";
              }
              else{
                $password   = SHA1($password);
                $joinedDate = date('Y-m-d');

                $query  = "INSERT INTO user(name, email, password, phone, role, status, joinedDate) 
                          VALUES('$name', '$email', '$password', '$phone', '2', '0', '$joinedDate') ";
                $result = mysqli_query($conn, $query);
                
                if($result){
                  $_SESSION['toastr']['message']   = array("Successfully registered! wait for an admin to approve your account.");
                  $_SESSION['toastr']['alertType'] = "success";
                }
                else{
                  $_SESSION['toastr']['message']   = array("Fatal error occured!");
                  $_SESSION['toastr']['alertType'] = "danger";

                }
              }

            }
      ?>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Full name" name="name" value="<?=$name;?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" value="<?=$email;?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="tel" class="form-control" placeholder="Phone number" name="phone" value="<?=$phone;?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <i class="fas fa-phone"></i>
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
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Retype password" name="re_password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="register">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div>

      <a href="index.php" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<?php include 'includes/admin_landing_includes/footer.php'; ?>
