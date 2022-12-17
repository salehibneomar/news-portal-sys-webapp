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
      
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Posts Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="posts.php">Posts</a></li>
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
                        <h3 class="card-title">All Posts</h3>

                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <div class="card-body table-overflow-controler-x">

                        <table class="table table-bordered table-striped w-100" id="dataTable">
                          <thead>
                            <tr>
                              <th width="6%">#ID</th>
                              <th width="6%">Image</th>
                              <th width="28%">Title</th>
                              <th>Category</th>
                              <th>Author</th>
                              <th>Date</th>
                              <th>Status</th>
                              <th width="12%">Action</th>
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
                          <h3 class="card-title">Add New Post</h3>

                          <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                  <i class="fas fa-minus"></i>
                              </button>
                          </div>

                      </div>

                      <div class="card-body px-5 py-4">
                       <form action="posts.php?operation=Insert" method="post" enctype="multipart/form-data" >
                          <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input class="form-control" type="text" name="title" id="title" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select class="form-control select2bs4" for="category" name="categoryId" style="width: 100%;" required>
                                    <option value="">--Select Category--</option>
                                        <?php 
                                            $query  = "SELECT id, name FROM category WHERE status=1 ORDER BY name ASC";
                                            $result = mysqli_query($conn, $query);

                                            while($category=mysqli_fetch_assoc($result)){ 
                                        ?>
                                            <option value="<?=$category['id'];?>"><?=$category['name'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="status">Publish Status</label>
                                    <select name="status" class="form-control" id="status" required>
                                        <option value="">--Post Status--</option>
                                        <option value="1">Publish</option>
                                        <option value="0">Draft</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label >Tags</label>
                                    <input type="text" value="" name="tags" data-role="tagsinput" class="bs4-tags-input">
                                    <small class="form-text text-muted">Use COMMA ( , ) to separate tags, max 6 tags (30 characters) allowed.</small>
                                </div>

                                <div class="form-group">
                                    <label >Upload Image</label>
                                        <div class="custom-file">
                                        <input name="image" type="file" class="custom-file-input" id="image" required>
                                        <label class="custom-file-label" for="image" id="imageLabel">Choose image</label>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="15" minlength="100" required></textarea>
                                <small class="form-text text-muted">Description must have minimum of 100 characters!</small>
                            </div>
                            
                            <div class="form-group mt-4 col-lg-12 text-right">
                                <button type="reset" class="btn btn-danger" id="formReset"><i class="fas fa-broom"></i>&ensp;Clear</button>
                                <button type="submit" class="btn btn-primary" name="addPost"><i class="fas fa-plus"></i>&ensp;Add</button>
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
                    $title       = mysqli_real_escape_string($conn, trim($title));
                    $description = mysqli_real_escape_string($conn, trim($description));
                    $tags        = mysqli_real_escape_string($conn, trim($tags));
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
                    $imagePath        = "images\posts\\";
                    $image            = null;


                    if(mb_strlen($title)<5){
                      array_push($formErrors, "Title is too short!");
                    }
                    else if(mb_strlen($title)>250){
                      array_push($formErrors, "Title is too long!");
                    }

                    if(mb_strlen($description)<100){
                      array_push($formErrors, "Description must have 100 characters!");
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

                      $authorId       = $_SESSION['userData']['id'];
                      $dateTimePosted = date('Y-m-d H:i:s');

                      if($hasValidImage){
                          $image = $image = rand(9, 999999)."_".date('Ymd_Hms')."_".str_replace(" ", "_", $imageName);

                          move_uploaded_file($imageTmpNamme,  $imagePath.$image);
                      }

                      $query = "INSERT INTO post(title, description, image, tags, status, dateTimePosted, categoryId, authorId) VALUES('$title', '$description', '$image', '$tags', '$status', '$dateTimePosted', '$categoryId', '$authorId')";

                      $result = mysqli_query($conn, $query);

                      if($result){
                        $_SESSION['toastr']['message']    = array("Post added successfully!");
                        $_SESSION['toastr']['alertType']  = "success";
                        header("Location: posts.php");
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
                         header("Location: posts.php");
                       }
                       else{
                          $query  = "SELECT * FROM post WHERE p_id='$editId' LIMIT 1";
                          $result = mysqli_query($conn, $query);
                          $data   = mysqli_fetch_assoc($result);

                          if(is_null($data)){
                            header("Location: posts.php");
                            exit();
                          }
                          
                          extract($data);
                          
                          if($_SESSION['userData']['role']==2 && $data['authorId']!=$_SESSION['userData']['id']){
                            header("Location: posts.php");
                            exit();
                          }
                       }
                    }
                    else{
                      header("Location: posts.php");
                    }
              ?>
                <div class="col-lg-12">
                    <div class="card card-info">

                      <div class="card-header">
                          <h3 class="card-title">Update Post</h3>

                          <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                  <i class="fas fa-minus"></i>
                              </button>
                          </div>

                      </div>

                      <div class="card-body p-4">
                      <?php 
                        $updatFormUrl = "posts.php?operation=Update";
                        if(isset($_GET['singlePost']) && $_GET['singlePost']=="true"){
                          $updatFormUrl = "posts.php?operation=Update&singlePost=true";
                        }
                      ?>
                         <form action="<?=$updatFormUrl; ?>" method="post" enctype="multipart/form-data" >
                            <div class="row">
                              <div class="col-lg-6">
                                  <div class="form-group">
                                      <label for="title">Title</label>
                                      <input class="form-control" type="text" name="title" id="title" value="<?=$title;?>" autocomplete="off" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="category">Category</label>
                                      <select class="form-control select2bs4" for="category" name="categoryId" style="width: 100%;" required>
                                      <option value="">--Select Category--</option>
                                          <?php 
                                              $query  = "SELECT id, name FROM category WHERE status=1 ORDER BY name ASC";
                                              $result = mysqli_query($conn, $query);

                                              while($category=mysqli_fetch_assoc($result)){
                                                      
                                          ?>
                                              <option value="<?=$category['id'];?>" <?php if($categoryId==$category['id']){ echo 'selected'; } ?> ><?=$category['name'];?></option>
                                          <?php } ?>
                                      </select>
                                  </div>

                                  <div class="form-group">
                                      <label for="status">Publish Status</label>
                                      <select name="status" class="form-control" id="status" required>
                                          <option value="">--Post Status--</option>
                                          <option value="1" <?php if($status==1){ echo 'selected'; } ?> >Publish</option>
                                          <option value="0" <?php if($status==0){ echo 'selected'; } ?> >Draft</option>
                                      </select>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label >Tags</label>
                                      <input type="text" value="<?=$tags;?>" name="tags" data-role="tagsinput" class="bs4-tags-input">
                                      <small class="form-text text-muted">Use COMMA ( , ) to separate tags, max 6 tags (30 characters) allowed.</small>
                                  </div>

                                  <div class="form-group">
                                      <label class="mb-3" >Upload Image
                                        <img class="d-inline ml-3 post-table-image" src="<?php if(empty($image)) { echo 'images/posts/default_banner.jpg'; }else { echo 'images/posts/'.$image; } ?>" alt="<?=$image;?>">
                                      </label>
                                          <div class="custom-file">
                                          <input name="image" type="file" class="custom-file-input" id="image">
                                          <label class="custom-file-label" for="image" id="imageLabel"><?php if(empty($image)){ echo 'Choose image'; } else{ echo 'Choose new image'; } ?></label>
                                      </div>
                                  </div>

                              </div>

                              <div class="col-lg-6">
                                  <label for="description">Description</label>
                                  <textarea class="form-control" name="description" id="description" rows="15" minlength="100" required><?=$description;?></textarea>
                                  <small class="form-text text-muted">Description must have minimum of 100 characters!</small>
                              </div>

                            <input type="hidden" name="updateId" value="<?=$p_id;?>">
                            <input type="hidden" name="postImage" value=<?=$image;?>>
                            <input type="hidden" name="authorId" value="<?=$authorId;?>">

                              <div class="form-group mt-4 col-lg-12 text-right">
                                  <button type="reset" class="btn btn-danger" id="formReset"><i class="fas fa-redo"></i>&ensp;Redo All</button>
                                  <button type="submit" class="btn btn-info" name="updatePost"><i class="fas fa-edit"></i>&ensp;Update Post</button>
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
                  $title       = mysqli_real_escape_string($conn, trim($title));
                  $description = mysqli_real_escape_string($conn, trim($description));
                  $tags        = mysqli_real_escape_string($conn, trim($tags));
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
                  $imagePath        = "images\posts\\";
                  $image            = null;


                  if(mb_strlen($title)<5){
                    array_push($formErrors, "Title is too short!");
                  }
                  else if(mb_strlen($title)>250){
                    array_push($formErrors, "Title is too long!");
                  }

                  if(mb_strlen($description)<100){
                    array_push($formErrors, "Description must have 100 characters!");
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

                  //Error Prints
                  if(!empty($formErrors)){
                    $_SESSION['toastr']['message']    = $formErrors;
                    $_SESSION['toastr']['alertType']  = "danger";
                  }
                  else{

                    $image = $postImage;

                    if($hasValidImage){
                      if(!empty($postImage)){
                        unlink("images\posts\\".$postImage);
                      }
                        $image = rand(9, 999999)."_".date('Ymd_Hms')."_".str_replace(" ", "_", $imageName);

                        move_uploaded_file($imageTmpNamme,  $imagePath.$image);
                    }

                    $query = "UPDATE post SET title='$title', description='$description', image='$image', tags='$tags', status='$status', categoryId='$categoryId' WHERE p_id='$updateId'";

                    $result = mysqli_query($conn, $query);

                    if($result){
                      if(mysqli_affected_rows($conn)==0){
                        $_SESSION['toastr']['message']    = array("No changes!");
                        $_SESSION['toastr']['alertType']  = "info";

                      }
                      else{
                        $_SESSION['toastr']['message']    = array("Post updated successfully!");
                        $_SESSION['toastr']['alertType']  = "success";

                      }

                      if(isset($_GET['singlePost']) && $_GET['singlePost']=="true"){
                        header("Location: single-post.php?pid=".$updateId);
                        exit();
                      }
                      else{
                        header("Location: posts.php");
                        exit();
                      }

  
                    }
                    else{
                      die("<br><b>Error: </b>".mysqli_error($conn));
                    } 

                  } 

                }
                else{
                  header("Location: posts.php");
                }
              } 
              else if($operation=='Delete'){
                if(isset($_GET['delete_id'])){
                  $deleteId = trim($_GET['delete_id']);
                  if(empty($deleteId)){
                    header("Location: posts.php");
                  }
                  else{
                    $query    = "SELECT image, authorId FROM post WHERE p_id = '$deleteId' LIMIT 1";
                    $result   = mysqli_query($conn, $query);
                    $data     = mysqli_fetch_assoc($result);
                    $image    = $data['image'];
                    $authorId = $data['authorId'];

                    if($_SESSION['userData']['role']==2 && $_SESSION['userData']['id']!=$authorId){
                      header("Location: posts.php");
                    }
                    else{

                      if(!empty($image)){
                          unlink("images\posts\\".$image);
                      }

                      $query  = "DELETE FROM post WHERE p_id = '$deleteId' LIMIT 1";
                      $result = mysqli_query($conn, $query);

                      if($result){
                        $_SESSION['toastr']['message']    = array("Post deleted successfully!");
                        $_SESSION['toastr']['alertType']  = "success";
                        header("Location: posts.php");
                        exit();
                      }
                      else{
                        die("<br><b>Error: </b>".mysqli_error($conn));
                      }
                    }
                    
                  }
                }
              } else{
                header("Location: posts.php");
              }
              ?>
              
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
