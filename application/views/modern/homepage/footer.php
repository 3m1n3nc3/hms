        <!--================ start footer Area  =================-->    
        <footer class="footer-area section_gap mt-5 py-3">
            <div class="container">
   
                <div class="row footer-bottom d-flex justify-content-between align-items-center">
                    <p class="col-lg-8 col-sm-12 footer-text m-0">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<?=date('Y')?> All rights reserved. <?= my_config('site_name')?>  
                         <!-- | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib </a> -->
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                    <div class="col-lg-4 col-sm-12 footer-social">
                        <a href="<?=social_link(my_config('contact_facebook'), 'facebook');?>"><i class="socicon-facebook"></i></a>
                        <a href="<?=social_link(my_config('contact_twitter'), 'twitter');?>"><i class="socicon-twitter"></i></a> 
                    </div>
                </div>
            </div>
        </footer>
        <!--================ End footer Area  =================-->
        
         
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS --> 
        <script src="<?= base_url('backend/modern/front/js/jquery-3.2.1.min.js'); ?>"> </script>
        <!-- jQuery UI -->
        <script src="<?= base_url('backend/modern/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
        <!-- Croppie -->
        <script src="<?= base_url('backend/js/plugins/croppie.js'); ?>"></script>
        <script src="<?= base_url('backend/modern/front/js/popper.js'); ?>"> </script>
        <script src="<?= base_url('backend/modern/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>  
        <script src="<?= base_url('backend/modern/front/vendors/owl-carousel/owl.carousel.min.js'); ?>"> </script>
        <script src="<?= base_url('backend/modern/front/js/jquery.ajaxchimp.min.js'); ?>"> </script>
        <script src="<?= base_url('backend/modern/front/js/mail-script.js'); ?>"> </script>  
        <script src="<?= base_url('backend/modern/front/vendors/bootstrap-datepicker/bootstrap-datetimepicker.min.js'); ?>"> </script>
        <script src="<?= base_url('backend/modern/front/vendors/nice-select/js/jquery.nice-select.js'); ?>"> </script> 
        <script src="<?= base_url('backend/modern/front/js/stellar.js'); ?>"> </script>  
        <script src="<?= base_url('backend/modern/front/vendors/lightbox/simpleLightbox.min.js'); ?>"> </script>  
        <script src="<?= base_url('backend/modern/front/js/custom.js'); ?>"> </script>   
        <!-- DateTimePicker -->
        <script src="<?= base_url('backend/modern/plugins/datetimepicker/build/jquery.datetimepicker.full.js'); ?>"></script> 

        <script src="<?= base_url('backend/js/hhms.js?time='.strtotime('NOW')); ?>"></script>

        <!-- Tooltips and toggle Initialization -->
        <script type="text/javascript"> 
          $(function () {
            $('[data-toggle="tooltip"]').tooltip()
          });
           
          $(function () {
            $('[data-toggle="popover"]').popover()
          })
        </script>
    </body>
</html>
