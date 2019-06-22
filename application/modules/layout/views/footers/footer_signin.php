    <div id="dropDownSelect1"></div>
	
    <!--===============================================================================================-->
        <script src="<?= base_url(); ?>assets/Login_v5/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
        <script src="<?= base_url(); ?>assets/Login_v5/vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
        <script src="<?= base_url(); ?>assets/Login_v5/vendor/bootstrap/js/popper.js"></script>
        <script src="<?= base_url(); ?>assets/Login_v5/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
        <script src="<?= base_url(); ?>assets/Login_v5/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
        <script src="<?= base_url(); ?>assets/Login_v5/vendor/daterangepicker/moment.min.js"></script>
        <script src="<?= base_url(); ?>assets/Login_v5/vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
        <script src="<?= base_url(); ?>assets/Login_v5/vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
        <script src="<?= base_url(); ?>assets/Login_v5/js/main.js"></script>
        <script src="<?= base_url(); ?>assets/js/plugins/sweetalert.min.js"></script>
        <?php 
            if( $this->session->flashdata('message')) {
                echo '<script> swal("Oops","'.$this->session->flashdata("message").'","error"); </script>';
            }
        ?>
    </body>
    </html>