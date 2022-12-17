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
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dasboard</a></li>
              <li class="breadcrumb-item active">Home</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


<?php

  $dashboardCardQuery = "SELECT
  (SELECT COUNT(*) FROM user ) AS 'total_Users_blue',
  (SELECT COUNT(*) FROM user where status = 1 AND role=1) AS 'active_Admins_green',
  (SELECT COUNT(*) FROM user where status = 0 AND role=1 ) AS 'inactive_Admins_red',
  (SELECT COUNT(*) FROM user where status = 1 AND role=2 ) AS 'active_Editors_green',
  (SELECT COUNT(*) FROM user where status = 0 AND role=2 ) AS 'inactive_Editors_red',
  (SELECT COUNT(*) FROM post ) AS 'total_Post_blue',
  (SELECT COUNT(*) FROM post WHERE status=1) AS 'published_Posts_green',
  (SELECT COUNT(*) FROM post WHERE status=0) AS 'drafted_Posts_yellow',
  (SELECT COUNT(*) FROM site_visitor) AS 'total_Site_Visitors_blue',
  (SELECT COUNT(*) FROM site_visitor_comments_on_post) AS 'total_Comments_blue',
  (SELECT COUNT(*) FROM category WHERE status=1) AS 'active_Categories_green',
  (SELECT COUNT(*) FROM category WHERE status=0) AS 'inactive_Categories_green'";

  $dashboardCardResult = mysqli_query($conn, $dashboardCardQuery);
  $dashboardCardResult = mysqli_fetch_assoc($dashboardCardResult);


?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
        <?php foreach ($dashboardCardResult as $key => $value) {
            $count = $value;
            $title = explode("_", $key);
            array_pop($title);
            $title = implode("_", $title);
            $title = ucwords(str_replace("_", " ", $title));
            $badge = explode("_", $key);
            $badge = end($badge);
          ?>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-<?=$badge; ?>">
              <div class="inner">
                <h3><?=$count; ?></h3>

                <p><?=$title; ?></p>
              </div>
              <div class="icon">
                <!--<i class="ion ion-bag"></i>-->
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <?php } ?>
          <!-- ./col -->

        </div>
        <!-- /.row -->


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
