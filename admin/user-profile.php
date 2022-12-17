<!-- Header -->
<?php include 'includes/header.php'; ?>
<!-- /.header -->


  <!-- Navbar -->
  <?php include 'includes/topbar.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include 'includes/sidebar.php'; ?>


  <?php 

    $userData = null;
    if(isset($_GET['uid']) && !empty($_GET['uid'])){
      $uid=$_GET['uid'];

      $getUserQuery  = "SELECT * FROM user WHERE id='$uid'";
      $getUserResult = mysqli_query($conn, $getUserQuery);
      $userData     = mysqli_fetch_assoc($getUserResult);
      
      if(is_null($userData)){
        header("Location: dashboard.php");
        exit();
      }

    }
    else{
      header("Location: dashboard.php");
      exit();
    }

  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <?php if($_SESSION['userData']['id']!=$userData['id']){ ?>
                <li class="breadcrumb-item active"><a href="users.php">All</a></li>
              <?php } ?>
              <li class="breadcrumb-item active"><?=$userData['name'];?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                  <h3 class="card-title">User</h3>
                  <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                  </div>
              </div>
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="<?php if(empty($userData['image'])) { echo 'images/users/default_avatar.jpg'; }else { echo 'images/users/'.$userData['image']; } ?>" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?=$userData['name'];?></h3>
                <?php $userRole = $userData['role']==1 ? "Admin" : "Editor"; ?>
                <p class="text-muted text-center"><?=$userRole;?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Total Post</b> 
                    <a class="float-right">
                      <?php 
                        $aid = $userData['id']; 

                      echo $conn->query("SELECT p_id FROM post WHERE authorId='$aid'")->num_rows; ?>
                    </a>
                  </li>
                  <li class="list-group-item">
                    <b>Phone</b> 
                    <a> <br>
                      <?=$userData['phone'];?>
                    </a>
                  </li>
                  <li class="list-group-item">
                    <b>Email</b> <br>
                    <a>
                    <?=$userData['email'];?>
                    </a>
                  </li>
                  <li class="list-group-item">
                    <b>Joined</b> <br>
                    <a>
                    <?=date('jS F Y', strtotime($userData['joinedDate'])) ;?>
                    </a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">About</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <strong><i class="fas fa-map-marker-alt mr-1"></i> Addres</strong>
                <p class="text-muted">
                  <?=$userData['address'];?>
                </p>
              <strong><i class="far fa-file-alt mr-1"></i>Bio</strong>
                <p class="text-muted">
                <?php $userBio = $userData['bio']==null ? "N/A" : $userData['bio']; ?>
                  <?=$userBio;?>
                </p>

                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-header">
              <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                </div>
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Recent Posts</a></li>
                  <?php if($userData['id']==$_SESSION['userData']['id']){ ?>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Update Profile</a></li>
                  <?php } ?>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                  <?php 
                      $recentPostQuery  = "SELECT p.*, COUNT(cmt.cid) AS 'cmtCount' FROM post p LEFT JOIN site_visitor_comments_on_post cmt ON cmt.pid=p.p_id WHERE p.authorId='$aid' GROUP BY p.p_id ORDER BY p.p_id DESC LIMIT 5";
                      $recentPostResult = mysqli_query($conn, $recentPostQuery);
                      $poststatusArray  = array("Draft", "Published");
                      while($row = mysqli_fetch_assoc($recentPostResult)){
                        extract($row);
                  ?>
                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="images/posts/<?=$image;?>">
                        <span class="username">
                          <p class="p-0 m-0 text-dark"><?=$title;?></p>
                        </span>
                        <span class="description"><?=$poststatusArray[$status]; ?> - <?=date('jS M y', strtotime($dateTimePosted)); ?></span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        <?=mb_substr($description, 0, 200)."...";?>
                      </p>

                      <p class="w-100">
                        <a href="single-post.php?pid=<?=$p_id;?>" class="link-blue text-sm mr-2"><i class="fas fa-share mr-1"></i>&ensp;View Post</a>
                        <span class="float-right">
                          <a  class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (<?=$cmtCount;?>)
                          </a>
                        </span>
                      </p>
                    </div>

                    <!-- /.post -->
                    <?php } ?>
                    
                  </div>

                  <?php if($userData['id']==$_SESSION['userData']['id']){ ?>
                  <div class="tab-pane" id="settings">
                  <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" >
                          <div class="row">
                            <div class="form-group col-md-12">
                                <label for="name">Full Name</label>
                                <input class="form-control" type="text" name="name" id="name" value="<?=$userData['name']; ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" name="email" id="email" value="<?=$userData['email']; ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">Phone No.</label>
                                <input class="form-control" type="tel" name="phone" id="phone" value="<?=
                                $userData['phone']; ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input class="form-control" type="password" name="password" id="password" >
                            </div>
                            <div class="form-group col-md-6">
                                <label for="re_password">Retype Password</label>
                                <input class="form-control" type="password" name="re_password" id="re_password" >
                            </div>
                            <div class="form-group col-md-12">
                                <label for="address">Address</label>
                                <input class="form-control" type="text" name="address" value="<?=$userData['address']; ?>" id="address">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="bio">Bio</label>
                                <textarea class="form-control" name="bio" id="bio" ><?=
                                $userData['bio']; ?></textarea>
                            </div>
                            <div class="form-group col-md-12">
                              <label>Upload Image
                              </label>
                              
                              <div class="custom-file">
                                  <input name="image" type="file" class="custom-file-input" id="image">
                                  <label class="custom-file-label" for="image" id="imageLabel"><?php if(empty($_SESSION['userData']['image'])){ echo 'Choose image'; } else{ echo 'Choose new image'; } ?></label>
                                </div>
                            </div>

                            <input type="hidden" name="updateId"  value="<?=$userData['id']; ?>">
                            <input type="hidden" name="userImage" value="<?=$userData['image']; ?>" >

                            <div class="form-group mt-4 col text-right">
                                <button type="reset" class="btn btn-danger" id="formReset"><i class="fas fa-redo"></i>&ensp;Redo</button>
                                <button type="submit" class="btn btn-info" name="updateUserBtn"><i class="fas fa-edit"></i>&ensp;Update</button>
                            </div>

                          </div>
                        </form> 
                        
                           
                  </div>

                    <?php if(isset($_POST['updateUserBtn'])){
                      extract($_POST);
                          
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

                            if(!empty($bio)){
                              if(mb_strlen($bio)>245){
                                array_push($formErrors, "Bio is too long! Try to keep the bio compact.");
                              }
                            }
                            else{
                              $bio = null;
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

                              $bio      = mysqli_real_escape_string($conn, $bio);
                              $address  = mysqli_real_escape_string($conn, $address);
                              $password = mysqli_real_escape_string($conn, $password);
                              
                              if($hasPassword){
                                $password   = sha1($password);
                                $query = "UPDATE user SET name='$name', email='$email', password='$password', address='$address', phone='$phone', image='$image', bio='$bio' WHERE id='$updateId' LIMIT 1";
                              }
                              else{
                                $query = "UPDATE user SET name='$name', email='$email', address='$address',  phone='$phone',  image='$image', bio='$bio' WHERE id='$updateId' LIMIT 1";
                              }
                              
        
                              $result = mysqli_query($conn, $query);
        
                              if($result){
                                if(mysqli_affected_rows($conn)==0){
                                  $_SESSION['toastr']['message']    = array("No changes!");
                                  $_SESSION['toastr']['alertType']  = "info";
                                  header("Location: user-profile.php?uid={$uid}");
                                  exit();
                                }
                                else{
                                  $_SESSION['toastr']['message']    = array("Profile pdated successfully!");
                                  $_SESSION['toastr']['alertType']  = "success";

                                  $_SESSION['userData']['name']=$name;
                                  $_SESSION['userData']['phone']=$phone;
                                  $_SESSION['userData']['email']=$email;
                                  $_SESSION['userData']['image']=$image;
                                  if($hasPassword){
                                  $_SESSION['userData']['password']=$password;
                                  }

                                  header("Location: user-profile.php?uid={$uid}");
                                  exit();
                    
                                }
                              }
                              else{
                                die("<br><b>Error: </b>".mysqli_error($conn));
                              }
                          
                            }
                          
                        
                    } 
                  
                  } ?>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
  <!-- /.content-wrapper -->

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>
  <!-- /.footer -->


<!-- Bottom elements (Scripts, Controlers) -->
  <?php include 'includes/bottom.php'; ?>
<!-- /.Bottom -->

