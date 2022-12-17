<!-- Header -->
<?php include 'includes/header.php'; ?>
<!-- /.header -->


  <!-- Navbar -->
  <?php include 'includes/topbar.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Category</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="category.php">Category</a></li>
              <li class="breadcrumb-item active">Manage Category</li>
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
                <!-- left col -->
                    <div class="col-lg-5 col-md-6">
                        <!-- Add/Update category form starts -->

                        <?php 
                          if(isset($_GET['edit_id'])){ 

                            $editId           = $_GET['edit_id'];
                            $query            = "SELECT * FROM category WHERE id = '$editId'";
                            $result           = mysqli_query($conn, $query);

                            $data = mysqli_fetch_assoc($result);

                            if($data==null){
                               header("Location: category.php");
                               exit();
                            }
                            
                            extract($data);
                        ?>
                          <div class="card card-info">
                            <div class="card-header">
                              <h3 class="card-title">
                                Update Category
                              </h3>

                              <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                  <i class="fas fa-minus"></i>
                                </button>
                              </div>
                            </div>
                            <div class="card-body p-3">
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="cat-name">Name</label>
                                        <input type="text" name="name" id="cat-name" class="form-control" value="<?=$name;?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="parentCat">Parent Category</label>
                                        <select name="parentCat" id="parentCat" class="form-control select2bs4" style="width: 100%;">
                                        <option value="0">--Select Parent Category if has any--</option>
                                              <?php 
                                                  $updateParentCategoryQuery  = "SELECT id as 'updateParentCatId', name AS 'updateParentCatName' FROM category WHERE id!='$editId' AND parent=0 ORDER BY name ASC";

                                                  $updateParentCategoryResult = mysqli_query($conn, 
                                                  $updateParentCategoryQuery);
                                                  
                                                  while($row = mysqli_fetch_assoc($updateParentCategoryResult)){
                                                    extract($row);
                                              ?>
                                                  <option value="<?=$updateParentCatId?>" <?php if($updateParentCatId==$parent){ echo 'selected'; } ?>><?=$updateParentCatName;?></option>
                                              <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="cat-status">Status</label>
                                        <select name="status" id="cat-status" class="form-control">
                                            <option value="">--Select Status--</option>
                                              <option value="1" <?php if($status==1){ echo "selected"; } ?> >Active</option>
                                              <option value="0" <?php if($status==0){ echo "selected"; } ?> >In-active</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="editId" value="<?=$id;?>">
                                    <div class="form-group">
                                        <button name="update" class="btn btn-info float-right"><i class="fas fa-edit"></i>&ensp;Update</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                          </div>
                        <?php } else { ?>
                          <div class="card card-primary">
                            <div class="card-header">
                              <h3 class="card-title">
                                Add New Category
                              </h3>

                              <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                  <i class="fas fa-minus"></i>
                                </button>
                              </div>
                            </div>
                            <div class="card-body p-3">
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="cat-name">Name</label>
                                        <input type="text" name="name" id="cat-name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="parentCat">Parent Category</label>
                                        <select name="parentCat" id="parentCat" class="form-control select2bs4" style="width: 100%;">
                                            <option value="0" selected>--Select Parent Category if has any--</option>
                                              <?php 
                                                  $addParentCategoryQuery  = "SELECT id as 'addParentCatId', name AS 'addParentCatName' FROM category WHERE parent=0 ORDER BY name ASC";

                                                  $addParentCategoryResult = mysqli_query($conn, 
                                                  $addParentCategoryQuery);
                                                  
                                                  while($row = mysqli_fetch_assoc($addParentCategoryResult)){
                                                    extract($row);
                                              ?>
                                                  <option value="<?=$addParentCatId?>"><?=$addParentCatName;?></option>
                                              <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="cat-status">Status</label>
                                        <select name="status" id="cat-status" class="form-control">
                                            <option value="">--Select Status--</option>
                                              <option value="1">Active</option>
                                              <option value="0">In-active</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button name="create" class="btn btn-primary float-right"><i class="fas fa-check-circle"></i>&ensp;Submit</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                          </div>
                        <?php } ?>

                        <!-- Add/Update category form ends -->
                    </div>
                <!-- /.left col -->

                <!-- right col -->
                    <div class="col-lg-7 col-md-6">
                        <!-- All category starts -->

                          <div class="card card-secondary">
                            <div class="card-header">
                              <h3 class="card-title">All Categories</h3>

                              <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                  <i class="fas fa-minus"></i>
                                </button>
                              </div>
                            </div>
                            <div class="card-body p-3 table-overflow-controler-x">
                            <table class="table table-bordered table-striped w-100" id="dataTable">
                                  <thead>
                                      <tr>
                                          <th style="width: 5%">
                                              #ID
                                          </th>
                                          <th style="width: 45%">
                                              Name
                                          </th>
                                          <th style="width: 15%">
                                              Type
                                          </th>
                                          <th style="width: 15%">
                                              Status
                                          </th>
                                          <th style="width: 20%">
                                              Action
                                          </th>
                                      </tr>
                                  </thead>
                                  <tbody>

                                  
                                  </tbody>
                              </table>
                            </div>
                            <!-- /.card-body -->
                          </div>
                        
                        <!-- All category ends -->

                        
                        <?php

                          $operationMode = false;

                            if(isset($_POST['create'])){
                              extract($_POST);
                              $formErrors = array();

                              if(empty(trim($name))){
                                $formErrors[]="Empty name!";
                              }
                              else if(mb_strlen($name)<2){
                                $formErrors[]="Name is too short!";
                              }
                              else if(mb_strlen($name)>150){
                                $formErrors[]="Name is too long!";
                              }

                              if(!empty($formErrors)){
                                  $_SESSION['toastr']['message']    = $formErrors;
                                  $_SESSION['toastr']['alertType']  = "danger";
                              }
                              else{
                                  $query  = "INSERT INTO category(name, parent, status) 
                                                        VALUES('$name', '$parentCat', '$status')";

                                  $result = mysqli_query($conn, $query);
                                  
                                  $operationMode = "add";
                              }

                            }
                            else if(isset($_POST['update'])){
                              extract($_POST);

                              $formErrors = array();

                              if(empty(trim($name))){
                                $formErrors[]="Empty name!";
                              }
                              else if(mb_strlen($name)<2){
                                $formErrors[]="Name is too short!";
                              }
                              else if(mb_strlen($name)>150){
                                $formErrors[]="Name is too long!";
                              }

                              if(!empty($formErrors)){
                                $_SESSION['toastr']['message']    = $formErrors;
                                $_SESSION['toastr']['alertType']  = "danger";
                              }
                              else{

                                $query  = "UPDATE category SET name='$name', parent ='$parentCat', status='$status' WHERE id='$editId'";

                                $result = mysqli_query($conn, $query);
  
                                $operationMode = "update";
                              }

                            }
                            else if(isset($_GET['delete'])){
                              $deleteId = $_GET['delete'];

                              $query  = "DELETE FROM category WHERE id='$deleteId' OR parent='$deleteId'";
                              $result = mysqli_query($conn, $query);

                              $operationMode = "delete";

                            }

                            if($operationMode!=false){
                              if($result){
                                  if($operationMode=="add"){
                                    $_SESSION['toastr']['message']    = array("Category added successfully!");
                                    $_SESSION['toastr']['alertType']  = "success";
                                  }
                                  else if($operationMode=="delete"){
                                    $_SESSION['toastr']['message']    = array("Category deleted successfully!");
                                    $_SESSION['toastr']['alertType']  = "success";
                                  }
                                  else if($operationMode=="update"){
                                    if(mysqli_affected_rows($conn)==0){
                                      $_SESSION['toastr']['message']    = array("No changes!");
                                      $_SESSION['toastr']['alertType']  = "info";
                                    }
                                    else{
                                      $_SESSION['toastr']['message']    = array("Category updated successfully!");
                                      $_SESSION['toastr']['alertType']  = "success";
                                    }
                                  }
                                  header("Location: category.php");
                                  exit();
                              }
                              else{
                                die("<br><b>Error: </b>".mysqli_error($conn));
                              }
                            }
                            
                        ?>

                    </div>
                </div>
                <!-- /.right col -->
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
