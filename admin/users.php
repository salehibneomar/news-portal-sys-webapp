<!-- Header -->
<?php include 'includes/header.php'; ?>
<!-- /.header -->


  <!-- Navbar -->
  <?php include 'includes/topbar.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include 'includes/sidebar.php'; ?>

  <?php 
    $operation = isset($_GET['operation'])? $_GET['operation']: 'Manage';
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
      <?php if($_SESSION['userData']['role']==1){ ?>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Users Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="users.php">Users</a></li>
              <li class="breadcrumb-item active"><?=$operation;?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
            <div class="row">
              <?php 
                if($operation=='Manage'){ ?>
                <div class="col-lg-12">
                    <div class="card card-secondary">
                      <div class="card-header">
                        <h3 class="card-title">All Users</h3>

                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <div class="card-body table-overflow-controler-x">
                        <table table class="table table-bordered table-striped w-100" id="dataTable">
                          <thead>
                            <tr>
                              <th width="5%">#ID</th>
                              <th>Image</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Phone</th>
                              <th>Role</th>
                              <th>Status</th>
                              <th>Joined</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer">
                        
                      </div>
                      <!-- /.card-footer-->
                    </div>
                </div>
              <?php } else if($operation=='Add'){ ?>
                <div class="col-lg-12">
                    <div class="card card-primary">

                      <div class="card-header">
                          <h3 class="card-title">Add New User</h3>

                          <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                  <i class="fas fa-minus"></i>
                              </button>
                          </div>

                      </div>

                      <div class="card-body px-5 py-4">
                       <form action="users.php?operation=Insert" method="post" enctype="multipart/form-data" >
                          <div class="row">
                            <div class="form-group col-md-12">
                                <label for="name">Full Name</label>
                                <input class="form-control" type="text" name="name" id="name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" name="email" id="email" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">Phone No.</label>
                                <input class="form-control" type="tel" name="phone" id="phone" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input class="form-control" type="password" name="password" id="password" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="re_password">Retype Password</label>
                                <input class="form-control" type="password" name="re_password" id="re_password" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="address">Address</label>
                                <input class="form-control" type="text" name="address" id="address">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="date">Joined Date</label>
                                <input class="form-control" type="date" name="joinedDate" id="date" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="role">User Role</label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="">--Select User Role--</option>
                                    <option value="2">Moderator</option>
                                    <option value="1">Admin</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="status">Account Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">--Select Account Status--</option>
                                    <option value="1">Active</option>
                                    <option value="0">In-active</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                              <label>Upload Image</label>
                                <div class="custom-file">
                                  <input name="image" type="file" class="custom-file-input" id="image">
                                  <label class="custom-file-label" for="image" id="imageLabel">Choose image</label>
                                </div>
                            </div>

                            <div class="form-group mt-4 col-md-12 text-right">
                                <button type="reset" class="btn btn-danger" id="formReset"><i class="fas fa-broom"></i>&ensp;Clear</button>
                                <button type="submit" class="btn btn-primary" name="addUser"><i class="fas fa-plus"></i>&ensp;Add</button>
                            </div>

                          </div>
                        </form>    
                      </div>
                          
                      <div class="card-footer">
                                          
                      </div>

                    </div> 
                </div>
              <?php } else if($operation=='Insert'){ 
                  if($_SERVER['REQUEST_METHOD']=='POST'){
                    //Form Text Data
                    extract($_POST);
                    $name  = ucwords($name);
                    $email = strtolower($email);
                    //Form Image Data
                    $imageName         = $_FILES['image']['name'];
                    $imageSize         = $_FILES['image']['size'];
                    $imageTmpNamme     = $_FILES['image']['tmp_name'];
                    $hasValidImage     = false;

                    $imageAllowedExtensions = array('jpg', 'jpeg', 'png');
                    // 2.5MB (2621440 bytes in binary)
                    $imageAllowedSize = 2621440;
                    $formErrors       = array();
                    /*$imageExtension   = explode('.', $imageName);
                    $imageExtension   = strtolower(end($imageExtension));*/
                    $imageExtension   = pathinfo($imageName, PATHINFO_EXTENSION);
                    $imagePath        = "images\users\\";

                    if(mb_strlen($name)<3){
                      array_push($formErrors, "Name is too short!");
                    }
                    else if(mb_strlen($name)>150){
                      array_push($formErrors, "Name is too long!");
                    }

                    if(strlen($password)<6){
                      array_push($formErrors, "Password is too short! minimum password size is 6 characters.");
                    }
                    else if($password!=$re_password){
                      array_push($formErrors, "Password and Retyped Password didn\\'t match!");
                    }

                    if(!empty($address)){
                      if(mb_strlen($address)>245){
                        array_push($formErrors, "Address is too long! Try to keep the address compact.");
                      }
                    }
                    else{
                      $address = 'N/A';
                    }

                    if(!empty($imageName)){
                      if(!in_array(strtolower($imageExtension), $imageAllowedExtensions)){
                        array_push($formErrors, "Invalid Image type! Please Upload a JPG, JPEG or PNG image.");
                      }
                      else{
                        if($imageSize>$imageAllowedSize){
                          array_push($formErrors, "Image size is too large! allowed max image size is 2.5MB.");
                        }
                        else if($imageSize<=0){
                          array_push($formErrors, "Invalid image size! please try another image.");
                        }
                        else{
                          $hasValidImage=true;
                        }
                      }
                    }

                    if(!empty($formErrors)){
                      $_SESSION['toastr']['message']    = $formErrors;
                      $_SESSION['toastr']['alertType']  = "danger";
                    }
                    else{
                      
                      $image    = null;
                      //Encrypted Password
                      $password = sha1($password);

                      if($hasValidImage){
                          $image = rand(99, 99999)."_".str_replace(" ","", strtolower($name)).
                                   "_".date('Ymd_His')."_".str_replace(" ", "_", $imageName);

                          move_uploaded_file($imageTmpNamme,  $imagePath.$image);
                      }

                      $address = mysqli_real_escape_string($conn, $address);

                      $query = "INSERT INTO user(name, email, password, address, phone, role, status, image, joinedDate)
                      VALUES('$name', '$email', '$password', '$address', '$phone', '$role', '$status', '$image', '$joinedDate')";

                      $result = mysqli_query($conn, $query);

                      if($result){
                        $_SESSION['toastr']['message']    = array("User added successfully!");
                        $_SESSION['toastr']['alertType']  = "success";
                        header("Location: users.php");
                        exit();
                      }
                      else{
                        die("<br><b>Error: </b>".mysqli_error($conn));
                      }

                    }

                  }
              }
              else if($operation=='Edit') { 
                    if(isset($_GET['edit_id'])){
                       $editId = trim($_GET['edit_id']);
                       if(empty($editId)){
                         header("Location: users.php");
                       }
                       else{
                          $query  = "SELECT * FROM user WHERE id='$editId' LIMIT 1";
                          $result = mysqli_query($conn, $query);
                          $data   = mysqli_fetch_assoc($result);

                          if(is_null($data)){
                            header("Location: users.php");
                            exit();
                          }
                          else{
                            extract($data);
                          }
                       }
                    }
                    else{
                      header("Location: users.php");
                      exit();
                    }
              ?>
                <div class="col-lg-12">
                    <div class="card card-info">

                      <div class="card-header">
                          <h3 class="card-title">Update User</h3>

                          <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                  <i class="fas fa-minus"></i>
                              </button>
                          </div>

                      </div>

                      <div class="card-body p-4">
                       <form action="users.php?operation=Update" method="post" enctype="multipart/form-data" >
                          <div class="row">
                            <div class="form-group col-md-12">
                                <label for="name">Full Name</label>
                                <input class="form-control" type="text" name="name" id="name" value="<?=$name;?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" name="email" id="email" value="<?=$email;?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">Phone No.</label>
                                <input class="form-control" type="tel" name="phone" id="phone" value="<?=$phone;?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">Reset Password</label>
                                <input class="form-control" type="password" name="password" id="password" >
                            </div>
                            <div class="form-group col-md-6">
                                <label for="re_password">Retype New Password</label>
                                <input class="form-control" type="password" name="re_password" id="re_password" >
                            </div>
                            <div class="form-group col-md-12">
                                <label for="address">Address</label>
                                <input class="form-control" type="text" name="address" value="<?=$address;?>" id="address">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="role">User Role</label>
                                <select name="role" id="role" class="form-control" required>

                                    <option value="">--Select User Role--</option>
                                    <option value="2" <?php if($role==2){ echo 'selected'; } ?> >Moderator</option>
                                    <option value="1" <?php if($role==1){ echo 'selected'; } ?> >Admin</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="status">Account Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">--Select Account Status--</option>
                                    <option value="1" <?php if($status==1){ echo 'selected'; } ?> >Active</option>
                                    <option value="0" <?php if($status==0){ echo 'selected'; } ?> >In-active</option>
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                              <label class="mb-3" >Upload Image
                                <img class="d-inline ml-3 user-image-table-sm" src="<?php if(empty($image)) { echo 'images/users/default_avatar.jpg'; }else { echo 'images/users/'.$image; } ?>" alt="<?=$image;?>">
                              </label>
                              
                                <div class="custom-file">
                                  <input name="image" type="file" class="custom-file-input" id="image">
                                  <label class="custom-file-label" for="image" id="imageLabel"><?php if(empty($image)){ echo 'Choose image'; } else{ echo 'Choose new image'; } ?></label>
                                </div>
                            </div>
                            <input type="hidden" name="updateId" value="<?=$id;?>">
                            <input type="hidden" name="userImage" value=<?=$image;?>>
                            <div class="form-group mt-4 col text-right">
                                <button type="reset" class="btn btn-danger" id="formReset"><i class="fas fa-redo"></i>&ensp;Redo All</button>
                                <button type="submit" class="btn btn-info" name="updateUser"><i class="fas fa-edit"></i>&ensp;Update User</button>
                            </div>

                          </div>
                        </form>    
                      </div>
                          
                      <div class="card-footer">
                                          
                      </div>

                    </div> 
                </div>
              <?php }
              else if($operation=="Update"){
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    //Form Text Data
                    extract($_POST);
                    $hasPassword = false;
                    $name        = ucwords($name);
                    $email       = strtolower($email);
                    //Form Image Data
                    $imageName         = $_FILES['image']['name'];
                    $imageSize         = $_FILES['image']['size'];
                    $imageTmpNamme     = $_FILES['image']['tmp_name'];
                    $hasValidImage     = false;

                    $imageAllowedExtensions = array('jpg', 'jpeg', 'png');
                    // 2.5MB (2621440 bytes in binary)
                    $imageAllowedSize = 2621440;
                    $formErrors       = array();
                    $imageExtension   = pathinfo($imageName, PATHINFO_EXTENSION);
                    $imagePath        = "images\users\\";

                    if(mb_strlen($name)<3){
                      array_push($formErrors, "Name is too short!");
                    }
                    else if(mb_strlen($name)>150){
                      array_push($formErrors, "Name is too long!");
                    }

                    if(!empty($password)){
                      if(strlen($password)<6){
                        array_push($formErrors, "Password is too short! minimum password size is 6 characters.");
                      }
                      else if($password!=$re_password){
                        array_push($formErrors, "Password and Retyped Password didn\\'t match!");
                      }
                      else{
                          $hasPassword = true;
                      }
                    }

                    if(!empty($address)){
                      if(mb_strlen($address)>245){
                        array_push($formErrors, "Address is too long! Try to keep the address compact.");
                      }
                    }
                    else{
                      $address = 'N/A';
                    }

                    if(!empty($imageName)){
                      if(!in_array(strtolower($imageExtension), $imageAllowedExtensions)){
                        array_push($formErrors, "Invalid Image type! Please Upload a JPG, JPEG or PNG image.");
                      }
                      else{
                        if($imageSize>$imageAllowedSize){
                          array_push($formErrors, "Image size is too large! allowed max image size is 2.5MB.");
                        }
                        else if($imageSize<=0){
                          array_push($formErrors, "Invalid image size! please try another image.");
                        }
                        else{
                          $hasValidImage=true;
                        }
                      }
                    }


                    if(!empty($formErrors)){
                      $_SESSION['toastr']['message']    = $formErrors;
                      $_SESSION['toastr']['alertType']  = "danger";
                    }
                    else{
                      
                      $image = $userImage;
                      $query = "";

                      if($hasValidImage){
                          if(!empty($userImage)){
                            unlink("images\users\\".$userImage);
                          }
                          $image = rand(99, 99999)."_".str_replace(" ","", strtolower($name)).
                                   "_".date('Ymd_Hms')."_".str_replace(" ", "_", $imageName);

                          move_uploaded_file($imageTmpNamme,  $imagePath.$image);
                      } 
                      
                      $address = mysqli_real_escape_string($conn, $address);

                      if($hasPassword){
                        $password   = sha1($password);
                        $query = "UPDATE user SET name='$name', email='$email', password='$password', address='$address',phone='$phone', role='$role', status='$status', image='$image' WHERE id='$updateId' LIMIT 1";
                      }
                      else{
                        $query = "UPDATE user SET name='$name', email='$email', address='$address', phone='$phone',role='$role', status='$status',  image='$image' WHERE id='$updateId' LIMIT 1";
                      }
                      

                      $result = mysqli_query($conn, $query);

                      if($result){
                        if(mysqli_affected_rows($conn)==0){
                          $_SESSION['toastr']['message']    = array("No changes!");
                          $_SESSION['toastr']['alertType']  = "info";
                          header("Location: users.php");
                          exit();
                        }
                        else{
                          $_SESSION['toastr']['message']    = array("User updated successfully!");
                          $_SESSION['toastr']['alertType']  = "success";
                          header("Location: users.php");
                          exit();
                        }
                      }
                      else{
                        die("<br><b>Error: </b>".mysqli_error($conn));
                      }
                  
                    }
                   
                }
                else{
                  header("Location: users.php");
                  exit();
                }
              } 
              else if($operation=='Delete'){
                if(isset($_GET['delete_id'])){
                  $deleteId = trim($_GET['delete_id']);
                  if(empty($deleteId)){
                    header("Location: users.php");
                    exit();
                  }
                  else{
                    $query  = "SELECT image FROM user WHERE id = '$deleteId' LIMIT 1";
                    $result = mysqli_query($conn, $query);
                    $image  = mysqli_fetch_assoc($result)['image'];

                    if(!empty($image)){
                        unlink("images\users\\".$image);
                    }

                    $query  = "DELETE FROM user WHERE id = '$deleteId' LIMIT 1";
                    $result = mysqli_query($conn, $query);

                    if($result){
                      $_SESSION['toastr']['message']    = array("User deleted successfully!");
                      $_SESSION['toastr']['alertType']  = "success";
                      header("Location: users.php");
                      exit();
                    }
                    else{
                      die("<br><b>Error: </b>".mysqli_error($conn));
                    }
                    
                  }
                }
              } else{
                header("Location: users.php");
                exit();
              }
              ?>
              

        <?php } else{
          header("Location: dashboard.php");
          exit();
        }?>
          
          </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>
  <!-- /.footer -->


<!-- Bottom elements (Scripts, Controlers) -->
  <?php include 'includes/bottom.php'; ?>
<!-- /.Bottom -->
