
<!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>

<!-- /.control-sidebar -->

</div>

<!-- ./wrapper -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard.js"></script>
  <script src="plugins/select2/js/select2.full.min.js"></script>
  <!-- bootstrap tags input -->
  <script src="plugins/bstagsinput/bootstrap-tagsinput.js"></script>
  <!--Data Tables -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <!-- CK editor -->
  <script src="//cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
  <script>
    CKEDITOR.replace( 'description' );
  </script>
  <script >
    
    var link = window.location.href
    var getUrlParams = new URL(link);
    page = link.split("/").pop().split('.php')[0];

    var url = (page == 'category')      ? 'getCategory.php'             : 
              (page == 'users')         ? 'getUser.php'                 : 
              (page == 'posts')         ? 'getPost.php'                 : 
              (page == 'visitors')      ? 'getVisitor.php'              : 
              (page == 'post-comments' || page == 'single-post') ? 'getPostComment.php'          : null;

      var DATA_TABLE = $('#dataTable').DataTable({
            "processing": true,
            "language": {
                  "processing": "Fetching Data..."
            },
            "serverSide": true,
            "ajax": {
              "url": "dt-server-side/"+url,
              "data": {
                "getSinglePostId": (page == 'single-post') ? getUrlParams.searchParams.get("pid") : null
              }
            },
            "pageLength": 5,
            "lengthMenu": [5, 10, 15],
            "order":  page=='category'  ? [[ 2, 'asc' ], [ 1, 'asc' ]] : 
                      page=='users'     ? [[ 0, 'asc' ]] 
                                                                       : [ 0, 'desc' ],
            "columnDefs": [
               page=='category'         ? { "targets": [4],    "orderable": false}     :
               page=='users'            ? { "targets": [8],    "orderable": false }    :
               page=='posts'            ? { "targets": [7],    "orderable": false }    :
              (page=='post-comments' ||
               page=='single-post')     ? { "targets": [7],    "orderable": false }    : false
            ]
        });

       if(page=='single-post'){
        DATA_TABLE.columns( [1,2] ).visible( false );
       }
    
  </script>
  <!-- Toaster -->
  <script src="plugins/toastr/toastr.min.js"></script>
  <script>

          toastr.options = {
            "closeButton":         true,
            "debug":               false,
            "newestOnTop":         false,
            "progressBar":         true,
            "positionClass":       "toast-top-center",
            "preventDuplicates":   false,
            "onclick":             null,
            "showDuration":        "300",
            "hideDuration":        "1000",      
            "timeOut":             "5000",
            "extendedTimeOut":     "5000",
            "showEasing":          "swing",
            "hideEasing":          "linear",
            "showMethod":          "fadeIn",
            "hideMethod":          "fadeOut"
          }

        <?php if(isset($_SESSION['toastr'])){ 
                    if($_SESSION['toastr']['alertType']=="success"){
                        foreach($_SESSION['toastr']['message'] as $msg){
        ?>
                          toastr.success('<?=$msg;?>');

        <?php } }else if($_SESSION['toastr']['alertType']=="danger"){ 
                        foreach($_SESSION['toastr']['message'] as $msg){ ?>

                          toastr.error('<?=$msg;?>');

        <?php } }else if($_SESSION['toastr']['alertType']=="info"){ 
                        foreach($_SESSION['toastr']['message'] as $msg){ ?>

                          toastr.info('<?=$msg;?>');

        <?php } }else if($_SESSION['toastr']['alertType']=="warning"){ 

                        foreach($_SESSION['toastr']['message'] as $msg){ ?>

                          toastr.warning('<?=$msg;?>');                    

        <?php } } unset($_SESSION['toastr']); } ?>

  </script>
  <!-- Developer's custom script -->
  <script src="custom/js/script.js"></script>


<?php ob_end_flush(); ?>
</body>
</html>