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
            <h1 class="m-0 text-dark">Visitors Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="users.php">Visitors</a></li>
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
                        <h3 class="card-title">All Visitors</h3>

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
                              <th width="5%">#ID</th>
                              <th width="30%">Name</th>
                              <th width="40%">Email</th>
                              <th width="10%">Registered</th>
                              <th width="10%">Status</th>
                              <th width="5%">Action</th>
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
              <?php } 
              
            else if($operation=="Update"){
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    
                    extract($_POST);
                    
                    $visitorUpdateQuery = "UPDATE site_visitor SET status='$status' WHERE vid='$editId' LIMIT 1";

                    $visitorUpdateResult = mysqli_query($conn, $visitorUpdateQuery);

                    if(mysqli_affected_rows($conn)==0){
                      $_SESSION['toastr']['message'] = array("No changes!");
                      $_SESSION['toastr']['alertType'] = "info";
                      header("Location: visitors.php");
                      exit();
                    }
                    else if(mysqli_affected_rows($conn)==1){
                      $_SESSION['toastr']['message'] = array("Visitor updated successfully!");
                      $_SESSION['toastr']['alertType'] = "success";
                      header("Location: visitors.php");
                      exit();
                    }
                    else{
                      $_SESSION['toastr']['message'] = array("Error occured!");
                      $_SESSION['toastr']['alertType'] = "danger";
                      header("Location: visitors.php");
                      exit();
                    }
                   
                }
                else{
                  header("Location: visitors.php");
                  exit();
                }
              }else{
                header("Location: visitors.php");
                exit();
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
