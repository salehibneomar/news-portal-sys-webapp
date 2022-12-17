    <!-- JQuery Library File -->
    <script type="text/javascript" src="assets/js/jquery-1.12.4.min.js"></script>
    <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script-->

    <!-- Bootstrap JS -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <!-- Owl Carousel JS -->
    <script src="assets/js/owl.carousel.min.js"></script>

    <!-- Isotop JS -->
    <script src="assets/js/isotop.min.js"></script>

    <!-- Fency Box JS -->
    <script src="assets/js/jquery.fancybox.min.js"></script>

    <!-- Toastr JS -->
    <script src="assets/toastr/toastr.min.js"></script>

    <!-- Easy Pie Chart JS -->
    <script src="assets/js/jquery.easypiechart.js"></script>

    <!-- JQuery CounterUp JS -->
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>

    <!-- BlueChip Extarnal Script -->
    <script type="text/javascript" src="assets/js/main.js"></script>
    
    <script>
      

        toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": false,
          "progressBar": true,
          "positionClass": "toast-bottom-center",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "5000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }

        <?php if(isset($_SESSION['toastr'])){ 
                    if($_SESSION['toastr']['alertType']=="success"){
                        foreach($_SESSION['toastr']['message'] as $msg){
        ?>
                          toastr.success('<?=$msg;?>');

        <?php } }else if($_SESSION['toastr']['alertType']=="error"){ 
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


    <?php
      ob_end_flush();
    ?>
  </body>
</html>