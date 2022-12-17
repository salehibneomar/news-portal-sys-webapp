<!-- Header -->
<?php include 'includes/header.php'; ?>
<!-- /.header -->


  <!-- Navbar -->
  <?php include 'includes/topbar.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include 'includes/sidebar.php'; ?>

  <?php

      $pid            = null;
      $singlePostData = null;
      if(isset($_GET['pid']) && !empty($_GET['pid'])){
          $pid = trim($_GET['pid']);

          $getSinglePostQuery = "SELECT * FROM single_post WHERE p_id='$pid'";
          $singlePostResult   = mysqli_query($conn, $getSinglePostQuery);

          $singlePostData     = mysqli_fetch_assoc($singlePostResult);

          if(is_null($singlePostData)){
              header("Location: posts.php");
              exit();
          }

          $statusArray = array("Draft", "Published");
          $statusBage = array("secondary", "success");
      }
      else{
        header("Location: posts.php");
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
            <h1 class="m-0 text-dark">Single Post Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active"><a href="posts.php">All</a></li>
              <li class="breadcrumb-item active">Single</li>
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
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                      <div class="card-header">
                          <h3 class="d-block card-title w-100 mb-3"><?=$singlePostData['title']; ?></h3>
                          <?php if(($_SESSION['userData']['role']==1 && $_SESSION['userData']['id']==$singlePostData['authorId']) ||
                                   ($_SESSION['userData']['role']==2 && $_SESSION['userData']['id']==$singlePostData['authorId']) ||
                                   ($_SESSION['userData']['role']==1 && $singlePostData['authorRole']==2)
                                   ) { ?>
                                                             <a class="d-inline-block btn btn-primary btn-sm" href="posts.php?operation=Edit&edit_id=<?=$pid; ?>&singlePost=true">Edit Post</a>
                          <?php } ?>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                  <i class="fas fa-minus"></i>
                                </button>
                            </div>
                      </div>
                      <div class="card-body">
                         <div class="row">
                              <div class="col-md-8">
                                    <img src="images/posts/<?=$singlePostData['image']; ?>" class="single-post-image rounded  d-block mx-auto img-fluid" >
                              </div>
                              <div class="col-md-4">
                                  <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>Category</strong> <br> <?=$singlePostData['singlePostCategoryName']; ?></li>
                                    <li class="list-group-item"> <strong>Date</strong>  <br> <?=date('jS M y', strtotime($singlePostData['dateTimePosted'])); ?></li>
                                    <li class="list-group-item"> <strong>Time</strong>  <br> <?=date('H:i:s A', strtotime($singlePostData['dateTimePosted'])); ?></li>
                                    <li class="list-group-item"> <strong>Author</strong>  <br> <?=$singlePostData['singlePostAuthorName']; ?></li>
                                    <li class="list-group-item"> <strong>Status</strong><br> <span class="badge badge-<?=$statusBage[$singlePostData['status']]; ?>"><?=$statusArray[$singlePostData['status']]; ?></span> </li>
                                    <li class="list-group-item"> <strong>Tags <br></strong>  
                                        <?php 
                                          $tagsArray = explode(",", $singlePostData['tags']);

                                          foreach($tagsArray as $tag){
                                        ?>
                                          <span class="badge badge-primary"><?=trim($tag); ?></span>
                                        <?php } ?>
                                    </li>
                                  </ul>
                              </div>
                              <div class="col-md-12">
                                  <hr>
                                  <h6 class="w-100 text-bold">Description</h6>
                                  <hr>

                                  <p  class="text-justify single-post-description"><?=$singlePostData['description'];?></p>
                              </div>
                         </div>
                      </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                      <div class="card-header">
                          <h3 class="card-title">All Comments Of This Post</h3>
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
                                <th width="5%">#CID</th>
                                <th width="5%">#PID</th>
                                <th >PT</th>
                                <th >Comment</th>
                                <th width="15%">Date</th>
                                <th width="15%">By</th>
                                <th width="5%">Status</th>
                                <th width="10%">Action</th>
                              </tr>
                            </thead>
                            <tbody>

                            </tbody>
                          </table>
                      </div>
                      <div class="card-footer">
                          <?php if(isset($_GET['operation']) && $_GET['operation']=='updateCommentOnSinglePost' ){
                                  if($_SERVER['REQUEST_METHOD']=='POST'){
                    
                                    extract($_POST);
                                    
                                    $commentUpdateQuery = "UPDATE site_visitor_comments_on_post SET status='$status' WHERE cid='$editId' LIMIT 1";
                          
                                    $commentUpdateResult = mysqli_query($conn, $commentUpdateQuery);
                                    
                                    if($commentUpdateResult){
                                        if(mysqli_affected_rows($conn)==0){
                                          $_SESSION['toastr']['message'] = array("No changes!");
                                          $_SESSION['toastr']['alertType'] = "info";
                                        }
                                        else if(mysqli_affected_rows($conn)==1){
                                          $_SESSION['toastr']['message'] = array("Comment updated successfully!");
                                          $_SESSION['toastr']['alertType'] = "success";
                                        }
                                        header("Location: single-post.php?pid=".$pid);
                                        exit();
                                    }
                                    else{
                                      die("<br><b>Error: </b>".mysqli_error($conn));
                                    }
                            }
                          } ?>
                      </div>
                    </div>
                </div>
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

