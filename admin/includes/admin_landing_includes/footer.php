
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- toaster -->
<script src="plugins/toastr/toastr.min.js"></script>

<script>

  toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "6000",
    "extendedTimeOut": "6000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }

        <?php if(isset($_SESSION['toastr'])){ 
                    if($_SESSION['toastr']['alertType']=="success"){
                        foreach($_SESSION['toastr']['message'] as $msg){
        ?>
                          toastr.success('<?=$msg;?>','');

        <?php } }else if($_SESSION['toastr']['alertType']=="danger"){ 
                        foreach($_SESSION['toastr']['message'] as $msg){ ?>

                          toastr.error('<?=$msg;?>');

        <?php } }else if($_SESSION['toastr']['alertType']=="info"){ 
                        foreach($_SESSION['toastr']['message'] as $msg){ ?>

                          toastr.info('<?=$msg;?>');

        <?php } }else if($_SESSION['toastr']['alertType']=="warning"){ 

                        foreach($_SESSION['toastr']['message'] as $msg){ ?>

                          toastr.warning('<?=$msg;?>',"aa");                    

        <?php } } unset($_SESSION['toastr']); } ?>

</script>

<?php
  ob_end_flush();
?>
</body>
</html>